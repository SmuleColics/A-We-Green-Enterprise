<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Project;
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
            ->with('success', 'Update posted.');
    }
}
