<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Material;
use App\Models\Quotation;
use App\Http\Controllers\NotificationController;
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
        $materials = Material::where('is_archived', false)->orderBy('category')->orderBy('name')->get();
        $quotation = $assessment->quotation;

        return view('admin.assessments.forms', compact('assessment', 'materials', 'quotation'));
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
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.location' => 'nullable|string|max:255',
        ]);

        $isNewQuotation = ! $assessment->quotation()->exists();
        $quotation = DB::transaction(function () use ($assessment, $validated) {
            $assessment->update([
                'assessment_notes' => $validated['assessment_notes'] ?? null,
                'assessment_form_completed_at' => now(),
            ]);

            $materials = Material::whereIn('id', collect($validated['items'])->pluck('material_id'))->where('is_archived', false)->get()->keyBy('id');
            abort_unless($materials->count() === collect($validated['items'])->pluck('material_id')->unique()->count(), 422, 'One or more selected materials are unavailable.');
            $assessment->items()->delete();
            foreach ($validated['items'] as $item) {
                $material = $materials[$item['material_id']];
                $assessment->items()->create(['material_id' => $material->id, 'item_name' => $material->name, 'quantity' => $item['quantity'], 'unit' => $material->unit, 'unit_price' => $material->selling_price ?? $material->unit_cost, 'location' => $item['location'] ?? null]);
            }

            $assessment->load('items.material');
            $subtotal = $assessment->items->sum(fn ($item) => (float) $item->quantity * (float) $item->unit_price);
            $service = $assessment->services[0] ?? 'General';
            $rate = $this->laborRate($service, $assessment->client_type);
            $quotation = Quotation::updateOrCreate(['assessment_id' => $assessment->id], [
                'reference_number' => 'QT-' . now()->format('Y') . '-' . str_pad((string) $assessment->id, 4, '0', STR_PAD_LEFT),
                'service_type' => $service, 'project_title' => $service . ' - ' . $assessment->client->user->full_name,
                'labor_rate' => $rate, 'materials_subtotal' => $subtotal, 'labor_total' => $subtotal * ($rate / 100),
                'grand_total' => $subtotal * (1 + $rate / 100), 'status' => 'Sent', 'sent_at' => now(),
            ]);
            $quotation->items()->delete();
            $grouped = $assessment->items->groupBy(fn ($item) => $item->material?->category === 'General' ? 'accessories' : 'item');
            foreach ($grouped as $key => $items) {
                if ($key === 'accessories') {
                    $quotation->items()->create(['description' => 'Accessories - ' . $items->pluck('item_name')->join(', '), 'quantity' => 1, 'unit' => 'lot', 'unit_price' => $items->sum(fn ($item) => (float) $item->quantity * (float) $item->unit_price), 'line_total' => $items->sum(fn ($item) => (float) $item->quantity * (float) $item->unit_price), 'is_grouped_accessory' => true]);
                } else foreach ($items as $item) {
                    $quotation->items()->create(['material_id' => $item->material_id, 'description' => $item->item_name, 'quantity' => $item->quantity, 'unit' => $item->unit, 'unit_price' => $item->unit_price, 'line_total' => $item->quantity * $item->unit_price]);
                }
            }
            return $quotation;
        });

        if ($isNewQuotation) {
            NotificationController::notify('Quotation', 'New quotation available', "Your quotation {$quotation->reference_number} is ready for review.", null, $quotation, $assessment->client->user_id);
        }

        return redirect()
            ->route('quotations.show', $quotation)
            ->with('success', $isNewQuotation ? 'Assessment form saved and quotation sent to the client.' : 'Assessment form and its quotation were updated.');
    }

    public function print(Assessment $assessment)
    {
        $assessment->load(['client.user', 'items.material']);
        return view('print.assessment', compact('assessment'));
    }

    private function laborRate(string $service, ?string $clientType): float
    {
        $service = strtolower($service); $clientType = strtolower((string) $clientType);
        if (str_contains($service, 'cctv')) return str_contains($clientType, 'home') || str_contains($clientType, 'residential') ? 15 : 20;
        if (str_contains($service, 'solar')) return 25;
        if (str_contains($service, 'public')) return 20;
        return 20;
    }
}
