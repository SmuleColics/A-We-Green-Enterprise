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
            ->where('is_archived', false)
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
        $onHold = $tasks->where('status', 'On Hold')->count();

        return view('admin.tasks.tasks', compact(
            'tasks', 'employees', 'assessments', 'total', 'pending', 'inProgress', 'completed', 'onHold'
        ));
    }

    public function show(Task $task)
    {
        $task->load('completedVia');

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
                'completed_at' => $task->completed_at?->format('Y-m-d H:i:s'),
                'archived_at' => $task->archived_at?->format('Y-m-d H:i:s'),
                'completed_via_task_id' => $task->completed_via_task_id,
                'is_auto_completed' => $task->is_auto_completed,
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
            'status' => 'nullable|in:Pending,In Progress,Completed,On Hold',
        ]);

        $previousStatus = $task->status;
        $statusChanged = isset($validated['status']) && $validated['status'] !== $previousStatus;
        $justCompleted = $statusChanged && $validated['status'] === 'Completed';
        $justReverted = $statusChanged && $previousStatus === 'Completed' && $validated['status'] !== 'Completed';

        if ($justCompleted) {
            $validated['completed_at'] = now();
            $validated['completed_via_task_id'] = null; // this is a direct/manual completion
        } elseif ($justReverted) {
            $validated['completed_at'] = null;
            $validated['completed_via_task_id'] = null;
        }

        $task->update($validated);

        $logMessage = $statusChanged
            ? "Task #{$task->id} status changed from {$previousStatus} to {$validated['status']}."
            : "Task #{$task->id} updated.";

        ActivityLogController::log('Task', 'Updated', $logMessage, auth()->id(), auth()->user()->full_name);

        // Notify the task's own employee about a direct status change (not for cascade-synced siblings, they get their own message below).
        if ($statusChanged) {
            $userId = $task->employee?->staff?->user_id;
            if ($userId) {
                NotificationController::notify(
                    module: 'Task',
                    title: 'Task Status Updated',
                    message: "Your task \"{$task->title}\" status was updated to {$validated['status']}.",
                    recipientRole: null,
                    notifiable: $task->assessment,
                    userId: $userId
                );
            }
        }

        // ── Sync: completing this task auto-completes sibling tasks on the same assessment ──
        if ($justCompleted) {
            $siblings = Task::where('assessment_id', $task->assessment_id)
                ->where('id', '!=', $task->id)
                ->where('is_archived', false)
                ->where('status', '!=', 'Completed')
                ->get();

            foreach ($siblings as $sibling) {
                $sibling->update([
                    'status' => 'Completed',
                    'completed_at' => now(),
                    'completed_via_task_id' => $task->id,
                ]);

                ActivityLogController::log(
                    'Task',
                    'Updated',
                    "Task #{$sibling->id} auto-completed (synced with Task #{$task->id} on assessment #{$task->assessment_id}).",
                    auth()->id(),
                    auth()->user()->full_name
                );

                $userId = $sibling->employee?->staff?->user_id;
                if ($userId) {
                    NotificationController::notify(
                        module: 'Task',
                        title: 'Task Completed',
                        message: "Your task \"{$sibling->title}\" was marked Completed automatically because a related task on the same assessment was finished.",
                        recipientRole: null,
                        notifiable: $task->assessment,
                        userId: $userId
                    );
                }
            }
        }

        // ── Reverse sync: only revert siblings that were completed BECAUSE of this task, never independently-completed ones ──
        if ($justReverted) {
            $syncedSiblings = Task::where('completed_via_task_id', $task->id)
                ->where('is_archived', false)
                ->get();

            foreach ($syncedSiblings as $sibling) {
                $sibling->update([
                    'status' => 'Pending',
                    'completed_at' => null,
                    'completed_via_task_id' => null,
                ]);

                ActivityLogController::log(
                    'Task',
                    'Updated',
                    "Task #{$sibling->id} auto-reopened (Task #{$task->id} it was synced from was reverted).",
                    auth()->id(),
                    auth()->user()->full_name
                );

                $userId = $sibling->employee?->staff?->user_id;
                if ($userId) {
                    NotificationController::notify(
                        module: 'Task',
                        title: 'Task Reopened',
                        message: "Your task \"{$sibling->title}\" was reopened because a related task on the same assessment was reverted.",
                        recipientRole: null,
                        notifiable: $task->assessment,
                        userId: $userId
                    );
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} updated successfully.",
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

    /**
     * Archive a task — soft-hides it from the active list without
     * deleting the row, matching the same is_archived/archived_at
     * pattern already used for Staff and Assessment records.
     */
    public function archive(Task $task)
    {
        $task->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Task',
            'Archived',
            "Task #{$task->id} ({$task->title}) archived.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} moved to archive.",
        ]);
    }

    /**
     * Restore an archived task back to the active list.
     */
    public function unarchive(Task $task)
    {
        $task->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        ActivityLogController::log(
            'Task',
            'Restored',
            "Task #{$task->id} ({$task->title}) restored from archive.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} restored.",
        ]);
    }

    /**
     * List archived tasks — feeds the "Archived Tasks" modal.
     */
    public function archived()
    {
        $tasks = Task::with(['employee.staff.user'])
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn ($task) => [
                'id' => $task->id,
                'title' => $task->title,
                'employee_name' => $task->employee->staff->user->full_name ?? 'N/A',
                'status' => $task->status,
                'status_badge' => $task->status_badge,
                'due_date' => $task->due_date->format('M j, Y'),
                'archived_at' => $task->archived_at?->format('M j, Y'),
            ]);

        return response()->json([
            'success' => true,
            'tasks' => $tasks,
        ]);
    }

    public function archivedPage()
    {
        $tasks = Task::with(['employee.staff.user', 'assessment.client.user'])
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get();

        $completed = $tasks->where('status', 'Completed')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $onHold = $tasks->where('status', 'On Hold')->count();

        return view('admin.tasks.archive-tasks', compact(
            'tasks', 'completed', 'inProgress', 'pending', 'onHold'
        ));
    }
}
