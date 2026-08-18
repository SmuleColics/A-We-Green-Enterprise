<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\Task;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $user = auth()->user();
        $employee = $user->staff->employee;

        $tasks = Task::where('employee_id', $employee->id)
            ->where('is_archived', false)
            ->with('assessment.client.user')
            ->get();

        $total = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $completed = $tasks->where('status', 'Completed')->count();

        // Same shape/labels as the admin dashboard's task list — soonest due first.
        $taskStatusLabels = [
            'Pending' => ['label' => 'To Do', 'class' => 'bg-secondary'],
            'In Progress' => ['label' => 'In Progress', 'class' => 'bg-primary'],
            'On Hold' => ['label' => 'On Hold', 'class' => 'bg-warning text-dark'],
        ];

        $myTasks = $tasks->where('status', '!=', 'Completed')
            ->sortBy('due_date')
            ->take(5)
            ->map(function ($task) use ($now, $taskStatusLabels) {
                $isOverdue = $task->due_date->lt($now->copy()->startOfDay());

                return [
                    'title' => $task->title,
                    'client_name' => $task->assessment->client->user->full_name ?? 'N/A',
                    'due_date' => $task->due_date,
                    'is_overdue' => $isOverdue,
                    'priority' => $isOverdue
                        ? ['label' => 'High', 'class' => 'bg-danger']
                        : ($now->diffInDays($task->due_date, false) <= 3
                            ? ['label' => 'Medium', 'class' => 'bg-warning text-dark']
                            : ['label' => 'Low', 'class' => 'bg-success']),
                    'status_display' => $taskStatusLabels[$task->status] ?? ['label' => $task->status, 'class' => 'bg-secondary'],
                ];
            })
            ->values();

        // ── Ongoing assessments — same system-wide view as the admin dashboard,
        // so employees can see the full day's schedule, not just their own visits ──
        $ongoingAssessments = Assessment::with('client.user')
            ->where('is_archived', false)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->whereDate('preferred_date', $now->toDateString())
            ->orderBy('time_slot')
            ->limit(5)
            ->get();

        // ── Mini calendar (current month) — dots mark every day with a
        // scheduled assessment, system-wide ──
        $calendarFirstDay = Carbon::create($now->year, $now->month, 1);
        $calendarDaysInMonth = $calendarFirstDay->daysInMonth;
        $calendarLeadingBlanks = $calendarFirstDay->dayOfWeek;

        $assessmentDays = Assessment::where('is_archived', false)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->whereMonth('preferred_date', $now->month)
            ->whereYear('preferred_date', $now->year)
            ->pluck('preferred_date')
            ->map(fn ($date) => $date->day)
            ->unique();

        // Same dot-color mapping as the admin dashboard's Recent Activity card.
        $activityDotClass = [
            'Created' => 'bg-success',
            'Updated' => 'bg-primary',
            'Archived' => 'bg-warning',
            'Restored' => 'bg-success',
            'Approved' => 'bg-success',
            'Rejected' => 'bg-danger',
        ];
        $recentActivity = ActivityLog::where('user_id', $user->id)
            ->where('is_archived', false)
            ->where('module', '!=', 'Auth')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($log) => [
                'dot_class' => $activityDotClass[$log->action] ?? 'bg-secondary',
                'description' => $log->description,
                'date' => $log->created_at->format('F j, Y'),
            ]);

        return view('employee.dashboard', compact(
            'total', 'pending', 'inProgress', 'completed', 'myTasks', 'recentActivity',
            'now', 'ongoingAssessments', 'calendarDaysInMonth', 'calendarLeadingBlanks', 'assessmentDays'
        ));
    }
}
