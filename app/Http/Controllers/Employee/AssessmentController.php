<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    // Read-only, system-wide schedule — same data as the admin Assessments page,
    // just without the admin-only actions (archive, assessment form, print).
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

        return view('employee.assessments', compact(
            'assessments', 'byDate', 'total', 'doneCount', 'submittedFormCount', 'pendingCount'
        ));
    }

    /**
     * Shape expected by the calendar's openDayModal()/loadAssessmentDetail() JS
     * — mirrors Admin\AssessmentScheduleController::toCardArray() exactly.
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
