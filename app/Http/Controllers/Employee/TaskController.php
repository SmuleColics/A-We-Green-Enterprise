<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('employee_id', auth()->user()->staff->employee->id)
            ->with(['assessment.client.user', 'employee.staff.user'])
            ->orderByDesc('due_date')
            ->get();

        $total = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $completed = $tasks->where('status', 'Completed')->count();

        return view('employee.tasks', compact(
            'tasks', 'total', 'pending', 'inProgress', 'completed'
        ));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()->json([
            'success' => true,
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'status_icon' => $task->status_icon,
                'status_badge' => $task->status_badge,
                'due_date' => $task->due_date->format('Y-m-d'),
                'days_until_due' => $task->days_until_due,
                'is_overdue' => $task->is_overdue,
                'completed_at' => $task->completed_at?->format('Y-m-d H:i:s'),
                'assessment' => [
                    'id' => $task->assessment->id,
                    'preferred_date' => $task->assessment->preferred_date->format('Y-m-d'),
                    'services' => $task->assessment->services,
                    'client' => [
                        'user' => [
                            'full_name' => $task->assessment->client->user->full_name,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,On Hold',
            'notes' => 'nullable|string|max:500',
            'hold_reason' => 'nullable|string|max:500',
        ]);

        $oldStatus = $task->status;
        $task->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'Completed') {
            $task->update(['completed_at' => now()]);
        }

        $employeeName = $task->employee->staff->user->full_name;
        $clientName = $task->assessment->client->user->full_name;

        ActivityLogController::log(
            'Task',
            'Updated',
            "Task #{$task->id} for {$clientName} status changed from {$oldStatus} to {$validated['status']} by {$employeeName}.",
            auth()->id(),
            auth()->user()->full_name
        );

        if ($validated['status'] === 'On Hold') {
            NotificationController::notify(
                module: 'Task',
                title: 'Task On Hold',
                message: "{$employeeName} placed the assessment task for {$clientName} on hold.",
                recipientRole: ['admin', 'secretary', 'super_admin'],
                notifiable: $task->assessment
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} status updated to {$validated['status']}.",
        ]);
    }
}
