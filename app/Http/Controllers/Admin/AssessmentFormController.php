<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
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

        $assessment->load(['client.user', 'items', 'tasks']);

        return view('admin.assessments.forms', compact('assessment'));
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
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit' => 'required|string|max:30',
            'items.*.location' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($assessment, $validated) {
            $assessment->update([
                'assessment_notes' => $validated['assessment_notes'] ?? null,
                'assessment_form_completed_at' => now(),
            ]);

            $assessment->items()->delete();

            $assessment->items()->createMany($validated['items']);
        });

        return redirect()
            ->route('assessments')
            ->with('success', 'Assessment form saved successfully. You can now create the quotation.');
    }
}
