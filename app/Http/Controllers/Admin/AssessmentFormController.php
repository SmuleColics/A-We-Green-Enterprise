<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Item;
use App\Models\Quotation;
use App\Http\Controllers\NotificationController;
use App\Services\QuotationConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentFormController extends Controller
{
    public function edit(Assessment $assessment)
    {
        abort_unless(
            $assessment->tasks->isNotEmpty()
                && $assessment->tasks->every(
                    fn ($task) => $task->status === 'Completed'
                ),
            403,
            'The assessment form can only be created after the assessment is done.'
        );

        $assessment->load(['client.user', 'items', 'tasks', 'quotation']);
        $items = Item::where('is_archived', false)->orderBy('category')->orderBy('name')->get();
        $quotation = $assessment->quotation;

        return view('admin.assessments.forms', compact('assessment', 'items', 'quotation'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        abort_unless(
            $assessment->tasks->isNotEmpty()
                && $assessment->tasks->every(
                    fn ($task) => $task->status === 'Completed'
                ),
            403
        );

        $validated = $request->validate([
            'assessment_notes' => 'nullable|string|max:5000',

            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.location' => 'nullable|string|max:255',
        ]);

        $isNewQuotation = ! $assessment->quotation()->exists();
        $wasRevisionRequested = $assessment->quotation?->status === 'Rejected';
        $quotation = DB::transaction(function () use ($assessment, $validated) {
            $assessment->update([
                'assessment_notes' => $validated['assessment_notes'] ?? null,
                'assessment_form_completed_at' => now(),
            ]);

            $items = Item::whereIn('id', collect($validated['items'])->pluck('item_id'))->where('is_archived', false)->get()->keyBy('id');
            abort_unless($items->count() === collect($validated['items'])->pluck('item_id')->unique()->count(), 422, 'One or more selected items are unavailable.');
            $assessment->items()->delete();
            foreach ($validated['items'] as $lineItem) {
                $item = $items[$lineItem['item_id']];
                $assessment->items()->create(['item_id' => $item->id, 'item_name' => $item->name, 'quantity' => $lineItem['quantity'], 'unit' => $item->unit, 'unit_price' => $item->selling_price ?? $item->unit_cost, 'location' => $lineItem['location'] ?? null]);
            }

            $assessment->load('items.item');
            // "Labor" category items (e.g. fiber termination, per-camera rehab
            // labor) are flat-priced service charges, not materials — the flat
            // price already IS the labor, so they're excluded from the base
            // the percentage labor rate is applied to (otherwise labor would
            // be charged on top of labor).
            $laborItems = $assessment->items->filter(fn ($lineItem) => $lineItem->item?->category === 'Labor');
            $materialItems = $assessment->items->diff($laborItems);
            $subtotal = $materialItems->sum(fn ($lineItem) => (float) $lineItem->quantity * (float) $lineItem->unit_price);
            $laborItemsTotal = $laborItems->sum(fn ($lineItem) => (float) $lineItem->quantity * (float) $lineItem->unit_price);
            $service = $assessment->services[0] ?? 'General';
            $rate = QuotationConfigService::resolveLaborRate($service, $assessment->client_type);
            $laborTotal = $subtotal * ($rate / 100);
            $quotation = Quotation::updateOrCreate(['assessment_id' => $assessment->id], [
                'reference_number' => 'QT-' . now()->format('Y') . '-' . str_pad((string) $assessment->id, 4, '0', STR_PAD_LEFT),
                'service_type' => $service, 'project_title' => $service . ' - ' . $assessment->client->user->full_name,
                'labor_rate' => $rate, 'items_subtotal' => $subtotal, 'labor_total' => $laborTotal,
                'grand_total' => $subtotal + $laborItemsTotal + $laborTotal, 'status' => 'Sent', 'sent_at' => now(),
                'revision_reason_category' => null, 'revision_reason' => null, 'revision_requested_at' => null,
            ]);
            $quotation->items()->delete();
            $grouped = $assessment->items->groupBy(fn ($lineItem) => $lineItem->item?->category === 'General' ? 'accessories' : 'item');
            foreach ($grouped as $key => $lineItems) {
                if ($key === 'accessories') {
                    $quotation->items()->create(['description' => 'Accessories - ' . $lineItems->pluck('item_name')->join(', '), 'quantity' => 1, 'unit' => 'lot', 'unit_price' => $lineItems->sum(fn ($lineItem) => (float) $lineItem->quantity * (float) $lineItem->unit_price), 'line_total' => $lineItems->sum(fn ($lineItem) => (float) $lineItem->quantity * (float) $lineItem->unit_price), 'is_grouped_accessory' => true]);
                } else foreach ($lineItems as $lineItem) {
                    $quotation->items()->create(['item_id' => $lineItem->item_id, 'description' => $lineItem->item_name, 'quantity' => $lineItem->quantity, 'unit' => $lineItem->unit, 'unit_price' => $lineItem->unit_price, 'line_total' => $lineItem->quantity * $lineItem->unit_price]);
                }
            }
            return $quotation;
        });

        if ($isNewQuotation) {
            ActivityLogController::log(
                'Quotation',
                'Created',
                "Quotation {$quotation->reference_number} created for {$assessment->client->user->full_name}.",
                auth()->id(),
                auth()->user()->full_name
            );

            NotificationController::notify('Quotation', 'New quotation available', "Your quotation {$quotation->reference_number} is ready for review.", null, $quotation, $assessment->client->user_id);
        } elseif ($wasRevisionRequested) {
            NotificationController::notify('Quotation', 'Revised quotation ready', "Your requested changes were applied. Quotation {$quotation->reference_number} is ready for review.", null, $quotation, $assessment->client->user_id);
        }

        return redirect()
            ->route('quotations.show', $quotation)
            ->with('success', $isNewQuotation ? 'Assessment form saved and quotation sent to the client.' : ($wasRevisionRequested ? 'Assessment form updated and the revised quotation was sent to the client.' : 'Assessment form and its quotation were updated.'));
    }

    public function print(Assessment $assessment)
    {
        $assessment->load(['client.user', 'items.item']);
        return view('print.assessment', compact('assessment'));
    }
}
