<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('quotation.assessment.client.user', 'checklistItems')
            ->where('is_archived', false)
            ->latest()
            ->get();

        $total = $projects->count();
        $notStarted = $projects->where('status', 'Not Started')->count();
        $inProgress = $projects->where('status', 'In Progress')->count();
        $onHold = $projects->where('status', 'On Hold')->count();
        $completed = $projects->where('status', 'Completed')->count();

        return view('admin.projects.projects', compact('projects', 'total', 'notStarted', 'inProgress', 'onHold', 'completed'));
    }

    public function show(Project $project)
    {
        $project->load(
            'quotation.assessment.client.user',
            'quotation.items',
            'checklistItems',
            'tasks.checklistItems',
            'tasks.employee.staff.user',
            'updates.user'
        );

        $employees = Employee::with('staff.user')->get();

        return view('admin.projects.show', compact('project', 'employees'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'status' => 'required|in:Not Started,In Progress,On Hold,Completed',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $wasCompleted = $project->status === 'Completed';
        $oldStatus = $project->status;
        $validated['completed_at'] = $validated['status'] === 'Completed'
            ? ($wasCompleted ? $project->completed_at : now())
            : null;

        $project->update($validated);

        ActivityLogController::log(
            'Project',
            'Updated',
            "Project {$project->reference_number} details were updated.",
            Auth::id(),
            Auth::user()->full_name
        );

        if ($oldStatus !== $project->status) {
            NotificationController::notify(
                module: 'Project',
                title: 'Project status changed',
                message: "Project {$project->reference_number} status changed from {$oldStatus} to {$project->status}.",
                recipientRole: ['admin', 'secretary', 'super_admin'],
                notifiable: $project
            );
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', "Project {$project->reference_number} was updated.");
    }

    public function archive(Project $project)
    {
        $project->update(['is_archived' => true, 'archived_at' => now()]);

        ActivityLogController::log(
            'Project',
            'Archived',
            "Project {$project->reference_number} moved to archive.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Project {$project->reference_number} moved to archive.",
        ]);
    }

    public function unarchive(Project $project)
    {
        $project->update(['is_archived' => false, 'archived_at' => null]);

        ActivityLogController::log(
            'Project',
            'Restored',
            "Project {$project->reference_number} restored from archive.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Project {$project->reference_number} restored.",
        ]);
    }

    public function archivedPage()
    {
        $projects = Project::with('quotation.assessment.client.user', 'checklistItems')
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get();

        $total = $projects->count();
        $notStarted = $projects->where('status', 'Not Started')->count();
        $inProgress = $projects->where('status', 'In Progress')->count();
        $onHold = $projects->where('status', 'On Hold')->count();
        $completed = $projects->where('status', 'Completed')->count();

        return view('admin.projects.archive-projects', compact(
            'projects', 'total', 'notStarted', 'inProgress', 'onHold', 'completed'
        ));
    }
}
