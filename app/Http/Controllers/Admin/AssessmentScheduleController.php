<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Task;
use App\Services\AssessmentConfigService;
use Illuminate\Support\Facades\Auth;

class AssessmentScheduleController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['client.user', 'assessors.staff.user', 'tasks', 'quotation'])
            ->where('status', 'Confirmed')
            ->where('is_archived', false)
            ->orderBy('preferred_date')
            ->get()
            ->map(function ($assessment) {
                $assessment->derived_status = $assessment->deriveStatus();

                return $assessment;
            });

        $total = $assessments->count();
        $doneCount = $assessments->where('derived_status', 'Done Assessment')->count();
        $submittedFormCount = $assessments->where('derived_status', 'Submitted Form')->count();
        $pendingCount = $assessments->where('derived_status', 'Pending')->count();

        $byDate = $assessments
            ->groupBy(fn ($a) => $a->preferred_date->format('Y-m-d'))
            ->map(fn ($dayAssessments) => $dayAssessments->map(fn ($a) => $this->toCardArray($a))->values());

        $clients = Client::with('user')->get();
        $employees = Employee::with('staff.user')->get();
        $workingDays = AssessmentConfigService::workingDays();
        $blockedDates = AssessmentConfigService::blockedDateStrings();

        return view('admin.assessments.assessments', compact(
            'assessments',
            'byDate',
            'total',
            'doneCount',
            'submittedFormCount',
            'pendingCount',
            'clients',
            'employees',
            'workingDays',
            'blockedDates'
        ));
    }

    public function archive(Assessment $assessment)
    {
        $assessment->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Assessment',
            'Archived',
            "Confirmed assessment #{$assessment->id} archived from the schedule.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Assessment #{$assessment->id} moved to archive.",
        ]);
    }

    public function unarchive(Assessment $assessment)
    {
        $assessment->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        ActivityLogController::log(
            'Assessment',
            'Restored',
            "Confirmed assessment #{$assessment->id} restored from the schedule archive.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Assessment #{$assessment->id} restored.",
        ]);
    }

    public function archivedPage()
    {
        $assessments = Assessment::with(['client.user', 'assessors.staff.user', 'tasks'])
            ->where('status', 'Confirmed')
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get()
            ->map(function ($assessment) {
                $assessment->derived_status = $assessment->deriveStatus();

                return $assessment;
            });

        $total = $assessments->count();
        $doneCount = $assessments->where('derived_status', 'Done Assessment')->count();
        $submittedFormCount = $assessments->where('derived_status', 'Submitted Form')->count();
        $pendingCount = $assessments->where('derived_status', 'Pending')->count();

        return view('admin.assessments.archive-assessments', compact(
            'assessments', 'total', 'doneCount', 'submittedFormCount', 'pendingCount'
        ));
    }

    /**
     * Shape expected by the existing openDayModal()/loadAssessmentDetail()
     * JS on the assessments blade — keeps the frontend untouched.
     */
    private function toCardArray(Assessment $a): array
    {
        $client = $a->client;
        $clientUser = $client->user;

        return [
            'id' => $a->id,
            'date' => $a->preferred_date->format('M j, Y'),
            'time' => $a->time_slot,
            'slot' => $a->time_slot,
            'client' => $clientUser->full_name,
            'contact' => $clientUser->contact_number ?? '—',
            'email' => $clientUser->email ?? '—',
            'clientType' => $a->client_type,
            'service' => implode(', ', $a->services ?? []),
            'establishment' => $a->establishment_type,
            'assessor' => $a->assessors->pluck('full_name')->implode(', ') ?: '—',
            'status' => $a->derived_status,
            'statusClass' => $a->derived_status === 'Done Assessment' ? 'success' : ($a->derived_status === 'Submitted Form' ? 'primary text-white' : 'warning text-dark'),
            'block' => $client->block ?? '—',
            'lot' => $client->lot ?? '—',
            'brgy' => $client->barangay ?? '—',
            'city' => $client->city ?? '—',
            'province' => $client->province ?? '—',
            'zip' => $client->zip_code ?? '—',
            'notes' => $a->notes ?? '',
        ];
    }
}
