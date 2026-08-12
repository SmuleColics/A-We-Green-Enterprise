<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;

class AssessmentScheduleController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['client.user', 'assessors.staff.user', 'tasks'])
            ->where('status', 'Confirmed')
            ->where('is_archived', false)
            ->orderBy('preferred_date')
            ->get()
            ->map(function ($assessment) {
                $assessment->derived_status = $this->deriveStatus($assessment);

                return $assessment;
            });

        $total = $assessments->count();
        $doneCount = $assessments->where('derived_status', 'Done Assessment')->count();
        $pendingCount = $assessments->where('derived_status', 'Pending')->count();

        // Grouped by date for the calendar view — keyed by Y-m-d so the
        // JS calendar renderer can look up a day's bookings directly.
        $byDate = $assessments
            ->groupBy(fn ($a) => $a->preferred_date->format('Y-m-d'))
            ->map(fn ($dayAssessments) => $dayAssessments->map(fn ($a) => $this->toCardArray($a))->values());

        return view('admin.assessments.assessments', compact(
            'assessments', 'byDate', 'total', 'doneCount', 'pendingCount'
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

    /**
     * "Done Assessment" once every Task tied to this assessment is
     * Completed. No tasks yet (shouldn't normally happen once assessors
     * are assigned at confirm time) falls back to "Pending".
     */
    private function deriveStatus(Assessment $assessment): string
    {
        if ($assessment->tasks->isEmpty()) {
            return 'Pending';
        }

        return $assessment->tasks->every(fn ($task) => $task->status === 'Completed')
            ? 'Done Assessment'
            : 'Pending';
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
            'statusClass' => $a->derived_status === 'Done Assessment' ? 'success' : 'warning text-dark',
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
