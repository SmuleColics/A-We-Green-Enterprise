<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use App\Models\Project;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function adminShow(Quotation $quotation)
    {
        $quotation->load('assessment.client.user', 'items.material', 'project');
        return view('admin.quotations.proposals', compact('quotation'));
    }

    public function uploadContract(Request $request, Quotation $quotation)
    {
        abort_unless($quotation->status === 'Approved', 422, 'Only an approved quotation can have its contract uploaded.');
        abort_if($quotation->project()->exists(), 422, 'A project has already been created for this quotation.');

        $validated = $request->validate([
            'contract' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $quotation->load('assessment.client.user', 'items');
        $client = $quotation->assessment->client;
        $location = collect([$client->city, $client->province])->filter()->join(', ');

        $project = DB::transaction(function () use ($request, $quotation, $location, $validated) {
            $path = $request->file('contract')->store('contracts', 'public');

            $quotation->update([
                'contract_status' => 'Completed',
                'contract_file' => $path,
                'contract_uploaded_at' => now(),
            ]);

            $project = Project::create([
                'quotation_id' => $quotation->id,
                'reference_number' => 'PRJ-' . now()->format('Y') . '-' . str_pad((string) $quotation->id, 4, '0', STR_PAD_LEFT),
                'project_title' => $quotation->project_title,
                'service_type' => $quotation->service_type,
                'location' => $location ?: null,
                'total_budget' => $quotation->grand_total,
                'status' => 'Not Started',
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'] ?? null,
            ]);

            foreach ($quotation->items as $item) {
                $project->checklistItems()->create([
                    'quotation_item_id' => $item->id,
                    'material_id' => $item->material_id,
                    'item_name' => $item->description,
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                ]);
            }

            return $project;
        });

        ActivityLogController::log(
            'Quotation',
            'Updated',
            "Contract confirmed for quotation {$quotation->reference_number}.",
            Auth::id(),
            Auth::user()->full_name
        );

        ActivityLogController::log(
            'Project',
            'Created',
            "Project {$project->reference_number} created from quotation {$quotation->reference_number}.",
            Auth::id(),
            Auth::user()->full_name
        );

        NotificationController::notify(
            module: 'Project',
            title: 'Project started',
            message: "Your project {$project->reference_number} has started following contract confirmation.",
            recipientRole: null,
            notifiable: $project,
            userId: $quotation->assessment->client->user_id
        );

        return redirect()
            ->route('projects.show', $project)
            ->with('success', "Contract confirmed. Project {$project->reference_number} was created.");
    }

    public function adminIndex()
    {
        $quotations = Quotation::with('assessment.client.user')->where('is_archived', false)->latest()->get();
        return view('admin.quotations.quotations', compact('quotations'));
    }

    public function archive(Quotation $quotation)
    {
        $quotation->update(['is_archived' => true, 'archived_at' => now()]);

        ActivityLogController::log(
            'Quotation',
            'Archived',
            "Quotation {$quotation->reference_number} moved to archive.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Quotation {$quotation->reference_number} moved to archive.",
        ]);
    }

    public function clientIndex()
    {
        $quotations = Quotation::with('assessment')
            ->whereHas('assessment', fn ($q) => $q->where('client_id', auth()->user()->client->id))
            ->where('is_archived', false)
            ->latest()
            ->get();
        return view('client.quotations.client-quotation', compact('quotations'));
    }

    public function clientShow(Quotation $quotation)
    {
        abort_unless($quotation->assessment->client_id === auth()->user()->client->id, 403);
        $quotation->load('assessment.client.user', 'items.material');
        return view('client.quotations.quotation-view', compact('quotation'));
    }

    public function approve(Quotation $quotation)
    {
        abort_unless($quotation->assessment->client_id === auth()->user()->client->id, 403);
        abort_unless($quotation->status === 'Sent', 422, 'This quotation has already been reviewed.');

        $quotation->update(['status' => 'Approved']);

        ActivityLogController::log(
            'Quotation',
            'Approved',
            "Quotation {$quotation->reference_number} was approved by the client.",
            Auth::id(),
            Auth::user()->full_name
        );

        NotificationController::notify(
            module: 'Quotation',
            title: 'Quotation approved',
            message: "{$quotation->assessment->client->user->full_name} approved quotation {$quotation->reference_number}.",
            recipientRole: ['admin', 'secretary', 'super_admin'],
            notifiable: $quotation
        );

        return response()->json([
            'success' => true,
            'message' => 'Quotation approved. Our team will reach out to schedule the next steps.',
        ]);
    }

    public function requestRevision(Request $request, Quotation $quotation)
    {
        abort_unless($quotation->assessment->client_id === auth()->user()->client->id, 403);
        abort_unless($quotation->status === 'Sent', 422, 'This quotation has already been reviewed.');

        $validated = $request->validate([
            'reason_category' => 'required|string|in:' . implode(',', Quotation::REVISION_REASON_CATEGORIES),
            'reason' => 'nullable|string|max:2000',
        ]);

        $quotation->update([
            'status' => 'Rejected',
            'revision_reason_category' => $validated['reason_category'],
            'revision_reason' => $validated['reason'] ?? null,
            'revision_requested_at' => now(),
        ]);

        $summary = $validated['reason_category'] . (($validated['reason'] ?? '') !== '' ? " — {$validated['reason']}" : '');

        ActivityLogController::log(
            'Quotation',
            'Rejected',
            "Quotation {$quotation->reference_number} - client requested changes: {$summary}",
            Auth::id(),
            Auth::user()->full_name
        );

        NotificationController::notify(
            module: 'Quotation',
            title: 'Revision requested',
            message: "{$quotation->assessment->client->user->full_name} requested changes to quotation {$quotation->reference_number}: {$summary}",
            recipientRole: ['admin', 'secretary', 'super_admin'],
            notifiable: $quotation
        );

        return response()->json([
            'success' => true,
            'message' => 'Your requested changes were sent to our team. We\'ll follow up with a revised quotation.',
        ]);
    }

    public function print(Quotation $quotation)
    {
        $quotation->load('assessment.client.user', 'items.material');
        return view('print.quotation', compact('quotation'));
    }

    public function clientPrint(Quotation $quotation)
    {
        abort_unless($quotation->assessment->client_id === auth()->user()->client->id, 403);
        return $this->print($quotation);
    }
}
