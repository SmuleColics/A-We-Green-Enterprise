<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentRequestController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with(['client.user', 'assessors.staff.user'])
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get();

        $employees = Employee::with('staff.user')->get();

        $total = $assessments->count();
        $confirmed = $assessments->where('status', 'Confirmed')->count();
        $pending = $assessments->where('status', 'Pending')->count();
        $declined = $assessments->where('status', 'Declined')->count();

        return view('admin.assessments.requests', compact(
            'assessments', 'employees', 'total', 'confirmed', 'pending', 'declined'
        ));
    }

    public function confirm(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array|min:1|max:2',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $clientName = $assessment->client->user->full_name;

        $assignedEmployees = DB::transaction(function () use ($assessment, $validated, $clientName) {
            $assessment->update(['status' => 'Confirmed']);
            $assessment->assessors()->sync($validated['employee_ids']);

            $assignedEmployees = Employee::whereIn('id', $validated['employee_ids'])
                ->with('staff.user')
                ->get();

            foreach ($assignedEmployees as $employee) {
                Task::create([
                    'employee_id' => $employee->id,
                    'assessment_id' => $assessment->id,
                    'title' => "Assessment for {$clientName}",
                    'description' => 'Conduct assessment for services: '.implode(', ', $assessment->services),
                    'due_date' => $assessment->preferred_date,
                    'status' => 'Pending',
                ]);
            }

            return $assignedEmployees;
        });

        $assessorNames = $assignedEmployees->pluck('full_name')->implode(', ');

        ActivityLogController::log(
            'Assessment',
            'Approved',
            "Assessment request #{$assessment->id} for {$clientName} confirmed and assigned to {$assessorNames}.",
            auth()->id(),
            auth()->user()->full_name
        );

        NotificationController::notify(
            module: 'Assessment',
            title: 'Your assessment request was confirmed',
            message: "Your request for {$assessment->preferred_date->format('M j, Y')} has been confirmed.",
            recipientRole: null,
            notifiable: $assessment,
            userId: $assessment->client->user_id
        );

        foreach ($assignedEmployees as $employee) {
            NotificationController::notify(
                module: 'Task',
                title: 'New Assessment Task Assigned',
                message: "You've been assigned to assess {$clientName}'s request on {$assessment->preferred_date->format('M j, Y')} ({$assessment->time_slot}).",
                recipientRole: null,
                notifiable: $assessment,
                userId: $employee->staff->user_id
            );
        }

        return response()->json([
            'success' => true,
            'message' => "Request #{$assessment->id} confirmed successfully.",
        ]);
    }

    public function decline(Request $request, Assessment $assessment)
    {
        $assessment->update(['status' => 'Declined']);

        $clientName = $assessment->client->user->full_name;

        ActivityLogController::log(
            'Assessment',
            'Rejected',
            "Assessment request #{$assessment->id} for {$clientName} was declined.",
            auth()->id(),
            auth()->user()->full_name
        );

        NotificationController::notify(
            module: 'Assessment',
            title: 'Your assessment request was declined',
            message: "Your request for {$assessment->preferred_date->format('M j, Y')} was declined. Contact us for details.",
            recipientRole: null,
            notifiable: $assessment,
            userId: $assessment->client->user_id
        );

        return response()->json([
            'success' => true,
            'message' => "Request #{$assessment->id} declined.",
        ]);
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
            "Assessment request #{$assessment->id} archived.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Request #{$assessment->id} moved to archive.",
        ]);
    }
}
