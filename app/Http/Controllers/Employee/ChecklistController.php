<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    // Read-only, system-wide view of checklists — same data as the admin
    // Checklists page, without the archive action.
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

        return view('employee.checklists', compact('projects', 'total', 'completed', 'inProgress', 'onHold'));
    }

    // Viewable by any employee. Editable only by an employee assigned to
    // this project (i.e. has a task on it) — everyone else gets a read-only view.
    public function show(Project $project)
    {
        $project->load('checklistItems.material', 'quotation.assessment.client.user');

        $canEdit = $project->tasks()
            ->where('employee_id', Auth::user()->staff->employee->id)
            ->where('is_archived', false)
            ->exists();

        return view('employee.checklist-show', compact('project', 'canEdit'));
    }

    public function update(Request $request, Project $project)
    {
        $isAssigned = $project->tasks()
            ->where('employee_id', Auth::user()->staff->employee->id)
            ->where('is_archived', false)
            ->exists();

        abort_unless($isAssigned, 403, 'Only employees assigned to this project can update its checklist.');

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
            "Materials checklist for project {$project->reference_number} was updated.",
            Auth::id(),
            Auth::user()->full_name
        );

        if ($newlyCompleted > 0 || $newlyUnavailable > 0) {
            $parts = [];
            if ($newlyCompleted > 0) $parts[] = "{$newlyCompleted} item(s) completed";
            if ($newlyUnavailable > 0) $parts[] = "{$newlyUnavailable} item(s) marked unavailable";

            NotificationController::notify(
                module: 'Checklist',
                title: 'Checklist updated',
                message: "Materials checklist for project {$project->reference_number} updated — ".implode(', ', $parts).'.',
                recipientRole: ['admin', 'secretary', 'super_admin'],
                notifiable: $project
            );
        }

        return redirect()
            ->route('employee.checklists.show', $project)
            ->with('success', 'Checklist updated.');
    }

    public function print(Project $project)
    {
        $project->load('checklistItems', 'quotation.assessment.client.user');

        return view('print.checklist', compact('project'));
    }
}
