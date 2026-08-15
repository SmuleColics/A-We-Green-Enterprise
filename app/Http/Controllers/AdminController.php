<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Quotation;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $now = now();
        $weekStart = $now->copy()->startOfWeek();
        $weekEnd = $now->copy()->endOfWeek();

        // ── Metric cards ──
        $assessmentsThisMonth = Assessment::where('is_archived', false)
            ->whereMonth('preferred_date', $now->month)
            ->whereYear('preferred_date', $now->year)
            ->count();
        $assessmentsToday = Assessment::where('is_archived', false)
            ->whereDate('preferred_date', $now->toDateString())
            ->count();

        $pendingQuotations = Quotation::where('is_archived', false)->where('status', 'Sent')->count();

        $activeProjects = Project::where('is_archived', false)->where('status', 'In Progress')->count();
        $projectsDueThisWeek = Project::where('is_archived', false)
            ->where('status', '!=', 'Completed')
            ->whereBetween('end_date', [$weekStart, $weekEnd])
            ->count();

        $tasksThisWeek = Task::where('is_archived', false)->where('status', '!=', 'Completed')
            ->whereBetween('due_date', [$weekStart, $weekEnd])->count()
            + ProjectTask::where('is_archived', false)->where('status', '!=', 'Completed')
            ->whereBetween('due_date', [$weekStart, $weekEnd])->count();
        $tasksOverdue = Task::where('is_archived', false)->where('status', '!=', 'Completed')
            ->whereDate('due_date', '<', $now->toDateString())->count()
            + ProjectTask::where('is_archived', false)->where('status', '!=', 'Completed')
            ->whereDate('due_date', '<', $now->toDateString())->count();

        // ── Today's assessments ──
        $ongoingAssessments = Assessment::with('client.user')
            ->where('is_archived', false)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->whereDate('preferred_date', $now->toDateString())
            ->orderBy('time_slot')
            ->limit(5)
            ->get();

        // ── Mini calendar (current month) ──
        $calendarFirstDay = Carbon::create($now->year, $now->month, 1);
        $calendarDaysInMonth = $calendarFirstDay->daysInMonth;
        $calendarLeadingBlanks = $calendarFirstDay->dayOfWeek; // 0 = Sunday, matches Su-first header

        $assessmentDays = Assessment::where('is_archived', false)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->whereMonth('preferred_date', $now->month)
            ->whereYear('preferred_date', $now->year)
            ->pluck('preferred_date')
            ->map(fn ($date) => $date->day)
            ->unique();

        $projectDueDays = Project::where('is_archived', false)
            ->whereNotNull('end_date')
            ->whereMonth('end_date', $now->month)
            ->whereYear('end_date', $now->year)
            ->pluck('end_date')
            ->map(fn ($date) => $date->day)
            ->unique();

        // ── Tasks list — assessment Tasks + ProjectTasks merged, soonest due first ──
        $taskStatusLabels = [
            'Pending' => ['label' => 'To Do', 'class' => 'bg-secondary'],
            'In Progress' => ['label' => 'In Progress', 'class' => 'bg-primary'],
            'On Hold' => ['label' => 'On Hold', 'class' => 'bg-warning text-dark'],
        ];

        $mergedTasks = Task::with('employee.staff.user')
            ->where('is_archived', false)->where('status', '!=', 'Completed')->get()
            ->map(fn ($t) => [
                'title' => $t->title,
                'employee_name' => $t->employee->staff->user->full_name ?? 'N/A',
                'due_date' => $t->due_date,
                'status' => $t->status,
            ])
            ->concat(
                ProjectTask::with('employee.staff.user')
                    ->where('is_archived', false)->where('status', '!=', 'Completed')->get()
                    ->map(fn ($t) => [
                        'title' => $t->title,
                        'employee_name' => $t->employee->full_name ?? 'Unassigned',
                        'due_date' => $t->due_date,
                        'status' => $t->status,
                    ])
            )
            ->sortBy('due_date')
            ->take(5)
            ->map(function ($t) use ($now, $taskStatusLabels) {
                $isOverdue = $t['due_date']->lt($now->copy()->startOfDay());
                $t['is_overdue'] = $isOverdue;
                $t['priority'] = $isOverdue
                    ? ['label' => 'High', 'class' => 'bg-danger']
                    : ($now->diffInDays($t['due_date'], false) <= 3
                        ? ['label' => 'Medium', 'class' => 'bg-warning text-dark']
                        : ['label' => 'Low', 'class' => 'bg-success']);
                $t['status_display'] = $taskStatusLabels[$t['status']] ?? ['label' => $t['status'], 'class' => 'bg-secondary'];

                return $t;
            })
            ->values();

        // ── Recent activity ──
        $activityDotClass = [
            'Created' => 'bg-success',
            'Updated' => 'bg-primary',
            'Archived' => 'bg-warning',
            'Restored' => 'bg-success',
            'Approved' => 'bg-success',
            'Rejected' => 'bg-danger',
        ];
        $recentActivity = ActivityLog::where('is_archived', false)
            ->where('module', '!=', 'Auth')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($log) => [
                'dot_class' => $activityDotClass[$log->action] ?? 'bg-secondary',
                'description' => $log->description,
                'date' => $log->created_at->format('F j, Y'),
            ]);

        return view('admin.dashboard', compact(
            'assessmentsThisMonth', 'assessmentsToday',
            'pendingQuotations',
            'activeProjects', 'projectsDueThisWeek',
            'tasksThisWeek', 'tasksOverdue',
            'ongoingAssessments',
            'now', 'calendarDaysInMonth', 'calendarLeadingBlanks', 'assessmentDays', 'projectDueDays',
            'mergedTasks', 'recentActivity'
        ));
    }

    // ASSESSMENT
    public function showAssessments()
    {
        return view('admin.assessments.assessments');
    }

    public function showAssessmentRequests()
    {
        return view('admin.assessments.requests');
    }

    // QUOTATION
    public function showQuotations()
    {
        return view('admin.quotations.quotations');
    }

    public function showQuotationProposals()
    {
        return view('admin.quotations.proposals');
    }

    // TASKS
    // public function showTasks()
    // {
    //     return view('admin.tasks.tasks');
    // }

    public function showArchiveTasks()
    {
        return view('admin.tasks.archive-tasks');
    }

    // PROJECTS
    public function showArchiveProjects()
    {
        return view('admin.projects.archive-projects');
    }

    // CHECKLISTS

    public function showArchiveChecklists()
    {
        return view('admin.checklists.archive-checklists');
    }

    // REPORTS

    public function showReports()
    {
        $now = now();

        // ═══════════════════════════ WEEKLY ═══════════════════════════
        $weekStart = $now->copy()->startOfWeek();
        $weekEnd = $now->copy()->endOfWeek();

        $weeklyAssessments = Assessment::where('is_archived', false)
            ->whereBetween('preferred_date', [$weekStart, $weekEnd])->count();
        $weeklyQuotationsSent = Quotation::where('is_archived', false)
            ->whereBetween('sent_at', [$weekStart, $weekEnd])->count();
        $weeklyCompletedProjects = Project::where('is_archived', false)->where('status', 'Completed')
            ->whereBetween('completed_at', [$weekStart, $weekEnd])->get();
        $weeklyProjectCost = $weeklyCompletedProjects->sum('total_budget');

        // Trailing 4 weeks (oldest → newest), matching the "Week 1..4" chart labels
        $weeklyAssessmentTrend = [];
        $weeklyAcceptedTrend = [];
        $weeklyRejectedTrend = [];
        for ($i = 3; $i >= 0; $i--) {
            $wStart = $weekStart->copy()->subWeeks($i);
            $wEnd = $weekEnd->copy()->subWeeks($i);
            $weeklyAssessmentTrend[] = Assessment::where('is_archived', false)
                ->whereBetween('preferred_date', [$wStart, $wEnd])->count();
            $weeklyAcceptedTrend[] = Quotation::where('is_archived', false)->where('status', 'Approved')
                ->whereBetween('sent_at', [$wStart, $wEnd])->count();
            $weeklyRejectedTrend[] = Quotation::where('is_archived', false)->where('status', 'Rejected')
                ->whereBetween('sent_at', [$wStart, $wEnd])->count();
        }

        $weeklyQuotationBreakdown = Quotation::where('is_archived', false)
            ->whereBetween('sent_at', [$weekStart->copy()->subWeeks(3), $weekEnd])
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        $weeklyClientGrowth = [];
        for ($d = $weekStart->copy(); $d->lte($weekEnd); $d->addDay()) {
            $weeklyClientGrowth[] = User::where('role', 'client')->where('created_at', '<=', $d->copy()->endOfDay())->count();
        }

        // ═══════════════════════════ MONTHLY ═══════════════════════════
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();

        $monthlyAssessments = Assessment::where('is_archived', false)
            ->whereBetween('preferred_date', [$monthStart, $monthEnd])->count();
        $monthlyQuotationsSent = Quotation::where('is_archived', false)
            ->whereBetween('sent_at', [$monthStart, $monthEnd])->count();
        $monthlyCompletedProjects = Project::where('is_archived', false)->where('status', 'Completed')
            ->whereBetween('completed_at', [$monthStart, $monthEnd])->get();
        $monthlyProjectCost = $monthlyCompletedProjects->sum('total_budget');

        $monthlyAssessmentTrend = [];
        $monthlyAcceptedTrend = [];
        $monthlyRejectedTrend = [];
        $monthlyClientGrowth = [];
        for ($m = 1; $m <= 12; $m++) {
            $mStart = Carbon::create($now->year, $m, 1)->startOfMonth();
            $mEnd = $mStart->copy()->endOfMonth();
            $monthlyAssessmentTrend[] = Assessment::where('is_archived', false)
                ->whereBetween('preferred_date', [$mStart, $mEnd])->count();
            $monthlyAcceptedTrend[] = Quotation::where('is_archived', false)->where('status', 'Approved')
                ->whereBetween('sent_at', [$mStart, $mEnd])->count();
            $monthlyRejectedTrend[] = Quotation::where('is_archived', false)->where('status', 'Rejected')
                ->whereBetween('sent_at', [$mStart, $mEnd])->count();
            $monthlyClientGrowth[] = User::where('role', 'client')->where('created_at', '<=', $mEnd)->count();
        }

        $monthlyQuotationBreakdown = Quotation::where('is_archived', false)
            ->whereYear('sent_at', $now->year)
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        // ═══════════════════════════ SHARED QUOTATION TABLE ═══════════════════════════
        $recentQuotations = Quotation::with('assessment.client.user')
            ->where('is_archived', false)
            ->whereNotNull('sent_at')
            ->orderByDesc('sent_at')
            ->limit(5)
            ->get();

        $reportsData = [
            'weekly' => [
                'assessmentsPerWeek' => $weeklyAssessmentTrend,
                'quotationBreakdown' => [
                    'Approved' => (int) ($weeklyQuotationBreakdown['Approved'] ?? 0),
                    'Sent' => (int) ($weeklyQuotationBreakdown['Sent'] ?? 0),
                    'Rejected' => (int) ($weeklyQuotationBreakdown['Rejected'] ?? 0),
                ],
                'clientGrowth' => $weeklyClientGrowth,
                'accepted' => $weeklyAcceptedTrend,
                'rejected' => $weeklyRejectedTrend,
            ],
            'monthly' => [
                'assessmentsPerMonth' => $monthlyAssessmentTrend,
                'quotationBreakdown' => [
                    'Approved' => (int) ($monthlyQuotationBreakdown['Approved'] ?? 0),
                    'Sent' => (int) ($monthlyQuotationBreakdown['Sent'] ?? 0),
                    'Rejected' => (int) ($monthlyQuotationBreakdown['Rejected'] ?? 0),
                ],
                'clientGrowth' => $monthlyClientGrowth,
                'accepted' => $monthlyAcceptedTrend,
                'rejected' => $monthlyRejectedTrend,
            ],
        ];

        return view('admin.reports.reports', compact(
            'reportsData',
            'weeklyAssessments', 'weeklyQuotationsSent', 'weeklyCompletedProjects', 'weeklyProjectCost',
            'monthlyAssessments', 'monthlyQuotationsSent', 'monthlyCompletedProjects', 'monthlyProjectCost',
            'recentQuotations'
        ));
    }

    // EMPLOYEES

    public function showEmployees()
    {
        return view('admin.employees.employees');
    }

    // CLIENTS

    public function showClients()
    {
        return view('admin.clients.clients');
    }

    // SYSTEM SETTINGS

    public function showAdminSettings()
    {
        return view('admin.admin-settings');
    }

    public function showAdminActivityLogs()
    {
        return view('admin.admin-activity-logs');
    }

    public function showAdminProfile()
    {
        return view('admin.admin-profile');
    }
}