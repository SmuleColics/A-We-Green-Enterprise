<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function index()
    {
        $projects = Project::with('quotation.assessment.client.user', 'checklistItems')
            ->where('is_archived', false)
            ->latest()
            ->get();

        $total = $projects->count();
        $completed = $projects->filter(fn ($p) => $p->checklistProgress() === 100)->count();
        $onHold = $projects->where('status', 'On Hold')->count();
        $inProgress = $total - $completed - $onHold;

        return view('admin.checklists.checklists', compact('projects', 'total', 'completed', 'inProgress', 'onHold'));
    }

    public function edit(Project $project)
    {
        $project->load('checklistItems.item', 'quotation.assessment.client.user');

        return view('admin.checklists.edit', compact('project'));
    }

    public function print(Project $project)
    {
        $project->load('checklistItems', 'quotation.assessment.client.user');

        return view('print.checklist', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:checklist_items,id',
            'items.*.outgoing_quantity' => 'nullable|numeric|min:0',
            'items.*.is_not_applicable' => 'nullable|boolean',
            'items.*.is_completed' => 'nullable|boolean',
            'items.*.returned_quantity' => 'nullable|numeric|min:0',
        ]);

        $items = $project->checklistItems()->get()->keyBy('id');

        $newlyCompleted = 0;
        $newlyUnavailable = 0;

        foreach ($validated['items'] as $row) {
            $item = $items->get($row['id']);
            if (! $item) continue;

            $isNotApplicable = (bool) ($row['is_not_applicable'] ?? false);
            $isCompleted = (bool) ($row['is_completed'] ?? false);
            $outgoingQuantity = $row['outgoing_quantity'] ?? null;
            $returnedQuantity = $row['returned_quantity'] ?? null;

            if ($isCompleted && ! $item->is_completed) $newlyCompleted++;
            if ($isNotApplicable && ! $item->is_not_applicable) $newlyUnavailable++;

            $item->update([
                'outgoing_quantity' => $outgoingQuantity,
                'outgoing_at' => $outgoingQuantity !== null ? ($item->outgoing_at ?? now()) : null,
                'is_not_applicable' => $isNotApplicable,
                'is_completed' => $isCompleted,
                'completed_at' => $isCompleted ? ($item->completed_at ?? now()) : null,
                'returned_quantity' => $returnedQuantity,
                'returned_at' => $returnedQuantity !== null ? ($item->returned_at ?? now()) : null,
            ]);
        }

        ActivityLogController::log(
            'Checklist',
            'Updated',
            "Items checklist for project {$project->reference_number} was updated.",
            Auth::id(),
            Auth::user()->full_name
        );

        // Only notify on meaningful progress (items completed / marked unavailable) —
        // not on every save, e.g. a quantity tweak with no completion change.
        if ($newlyCompleted > 0 || $newlyUnavailable > 0) {
            $parts = [];
            if ($newlyCompleted > 0) $parts[] = "{$newlyCompleted} item(s) completed";
            if ($newlyUnavailable > 0) $parts[] = "{$newlyUnavailable} item(s) marked unavailable";

            NotificationController::notify(
                module: 'Checklist',
                title: 'Checklist updated',
                message: "Items checklist for project {$project->reference_number} updated — ".implode(', ', $parts).'.',
                recipientRole: ['admin', 'secretary', 'super_admin'],
                notifiable: $project
            );
        }

        return redirect()
            ->route('checklists.edit', $project)
            ->with('success', 'Checklist updated.');
    }
}
