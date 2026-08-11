<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['employee.staff.user', 'assessment.client.user'])
            ->orderByDesc('due_date')
            ->get();

        $employees = Employee::with('staff.user')->get();
        $assessments = Assessment::with(['client.user', 'assessors.staff.user'])
            ->where('is_archived', false)
            ->get();

        $total = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $completed = $tasks->where('status', 'Completed')->count();

        return view('admin.tasks.tasks', compact(
            'tasks', 'employees', 'assessments', 'total', 'pending', 'inProgress', 'completed'
        ));
    }

    public function show(Task $task)
    {
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
                'employee' => [
                    'id' => $task->employee->id,
                    'position' => $task->employee->position,
                    'staff' => [
                        'user' => [
                            'full_name' => $task->employee->staff->user->full_name,
                        ],
                    ],
                ],
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
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        ActivityLogController::log(
            'Task',
            'Updated',
            "Task #{$task->id} updated.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} updated successfully.",
        ]);
    }

    public function destroy(Task $task)
    {
        $taskId = $task->id;
        $task->delete();

        ActivityLogController::log(
            'Task',
            'Deleted',
            "Task #{$taskId} deleted.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$taskId} deleted successfully.",
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'assessment_id' => 'required|exists:assessments,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $assessment = Assessment::find($validated['assessment_id']);
        $employee = Employee::find($validated['employee_id']);

        $task = Task::create([
            'employee_id' => $validated['employee_id'],
            'assessment_id' => $validated['assessment_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => 'Pending',
        ]);

        // Notify the employee
        NotificationController::notify(
            module: 'Task',
            title: 'New Task Assigned',
            message: "You have been assigned a new task: {$validated['title']}",
            recipientRole: null,
            notifiable: $assessment,
            userId: $employee->staff->user_id
        );

        ActivityLogController::log(
            'Task',
            'Created',
            "Task #{$task->id} assigned to {$employee->staff->user->full_name} for assessment #{$assessment->id}.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task created and assigned to {$employee->staff->user->full_name}.",
            'task' => $task,
        ]);
    }
}
