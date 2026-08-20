<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    // Read-only, system-wide view of projects — same data as the admin
    // Projects page, without the archive/edit/manage actions.
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

        return view('employee.projects', compact('projects', 'total', 'notStarted', 'inProgress', 'onHold', 'completed'));
    }

    public function show(Project $project)
    {
        $project->load(
            'quotation.assessment.client.user',
            'checklistItems',
            'tasks.checklistItems',
            'tasks.employee.staff.user',
            'updates.user'
        );

        return view('employee.project-show', compact('project'));
    }
}
