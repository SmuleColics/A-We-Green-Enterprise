<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Assessment;

class ClientController extends Controller
{
    public function showPortal()
    {
        $user = auth()->user();

        $logs = ActivityLog::where('user_id', $user->id)
            ->where('module', '!=', 'Auth')
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->limit(15)
            ->get();

        $today = $logs->filter(fn ($log) => $log->created_at->isToday());
        $thisWeek = $logs->filter(fn ($log) => ! $log->created_at->isToday() && $log->created_at->greaterThanOrEqualTo(now()->startOfWeek())
        );
        $older = $logs->filter(fn ($log) => $log->created_at->lessThan(now()->startOfWeek()));

        return view('client.portal', compact('today', 'thisWeek', 'older'));
    }

    public function showClientAssessment()
{
    $client = auth()->user()->client;

    $assessments = Assessment::with('tasks')
        ->where('client_id', $client->id)
        ->orderByDesc('preferred_date')
        ->get();

    $activeAssessments = $assessments->whereIn('status', ['Pending', 'Confirmed'])->values()
        ->map(function ($a) {
            $a->derived_status = $a->status === 'Confirmed' ? $a->deriveStatus() : $a->status;

            return $a;
        });
    $historyAssessments = $assessments->whereIn('status', ['Declined', 'Cancelled'])->values();

    $total = $assessments->count();
    $confirmed = $assessments->where('status', 'Confirmed')->count();
    $pending = $assessments->where('status', 'Pending')->count();
    $declined = $assessments->where('status', 'Declined')->count();

    return view('client.assessments.client-assessment', compact(
        'activeAssessments', 'historyAssessments', 'total', 'confirmed', 'pending', 'declined'
    ));
}

    public function showClientAssessmentForm()
    {
        return view('client.assessments.assessment-form');
    }

    public function showAssessmentDetails(Assessment $assessment)
    {
        abort_unless($assessment->client_id === auth()->user()->client->id, 403);
        $assessment->load(['client.user', 'items.material', 'assessors.staff.user', 'quotation']);

        return view('client.assessments.assessment-view', compact('assessment'));
    }

    public function printAssessment(Assessment $assessment)
    {
        abort_unless($assessment->client_id === auth()->user()->client->id, 403);
        $assessment->load(['client.user', 'items.material']);

        return view('print.assessment', compact('assessment'));
    }

    public function showClientQuotation()
    {
        return view('client.quotations.client-quotation');
    }

    public function showClientViewQuotation()
    {
        return view('client.quotations.quotation-view');
    }

    public function showClientProject()
    {
        return view('client.projects.client-project');
    }

    public function showProjectMonitoring()
    {
        return view('client.projects.project-monitoring');
    }

    public function showClientProfile()
    {
        return view('client.profile');
    }

    public function showClientSettings()
    {
        return view('client.settings');
    }

    public function showActivityLogs()
    {
        return view('client.activity-logs');
    }
}