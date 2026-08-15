<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectUpdateController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
            'images' => 'nullable|array|max:6',
            'images.*' => 'image|max:5120',
        ]);

        $paths = [];
        foreach ($request->file('images', []) as $image) {
            $paths[] = $image->store('project-updates', 'public');
        }

        $project->updates()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'images' => $paths,
        ]);

        ActivityLogController::log(
            'Project',
            'Updated',
            "A progress update was posted on project {$project->reference_number}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Update posted.')
            ->with('expand_section', 'updatesSection');
    }

    public function archive(ProjectUpdate $update)
    {
        $update->update(['is_archived' => true, 'archived_at' => now()]);

        ActivityLogController::log(
            'Project',
            'Archived',
            "A progress update on project {$update->project->reference_number} was archived.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json(['success' => true, 'message' => 'Update moved to archive.']);
    }

    public function unarchive(ProjectUpdate $update)
    {
        $update->update(['is_archived' => false, 'archived_at' => null]);

        ActivityLogController::log(
            'Project',
            'Restored',
            "A progress update on project {$update->project->reference_number} was restored.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json(['success' => true, 'message' => 'Update restored.']);
    }

    public function archivedPage(Project $project)
    {
        $updates = $project->updates()
            ->where('is_archived', true)
            ->with('user')
            ->reorder('archived_at', 'desc')
            ->get();

        return view('admin.projects.archive-updates', compact('project', 'updates'));
    }
}
