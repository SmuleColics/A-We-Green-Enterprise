<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ActivityLogController;
use App\Models\Assessment;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function adminShow(Quotation $quotation)
    {
        $quotation->load('assessment.client.user', 'items.material');
        return view('admin.quotations.proposals', compact('quotation'));
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
