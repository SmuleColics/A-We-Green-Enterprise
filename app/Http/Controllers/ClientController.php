<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\Notification;
use App\Models\Project;
use App\Services\AssessmentConfigService;
use Illuminate\Http\Request;

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

    // Sibling assessments (same booking_group_id) came from one wizard
    // submission for multiple services in the same visit — flag them so
    // the table can show a "part of the same visit" hint.
    $groupCounts = $assessments->whereNotNull('booking_group_id')->groupBy('booking_group_id')->map->count();
    $annotateGroup = function ($a) use ($assessments, $groupCounts) {
        $a->is_grouped = $a->booking_group_id && ($groupCounts[$a->booking_group_id] ?? 0) > 1;
        $a->sibling_ids = $a->is_grouped
            ? $assessments->where('booking_group_id', $a->booking_group_id)->where('id', '!=', $a->id)->pluck('id')
            : collect();

        return $a;
    };

    $activeAssessments = $assessments->whereIn('status', ['Pending', 'Confirmed'])->values()
        ->map(function ($a) use ($annotateGroup) {
            $a->derived_status = $a->status === 'Confirmed' ? $a->deriveStatus() : $a->status;

            return $annotateGroup($a);
        });
    $historyAssessments = $assessments->whereIn('status', ['Declined', 'Cancelled'])->values()
        ->map($annotateGroup);

    $total = $assessments->count();
    $confirmed = $assessments->where('status', 'Confirmed')->count();
    $pending = $assessments->where('status', 'Pending')->count();
    $declined = $assessments->where('status', 'Declined')->count();

    $clientTypes = AssessmentConfigService::activeClientTypes();
    $services = AssessmentConfigService::activeServices();
    $cctvService = $services->firstWhere('name', 'CCTV Setup');
    $coverageProvincesByRegion = AssessmentConfigService::activeProvinces()->groupBy('region');

    $estabOptionsForWizard = $clientTypes->mapWithKeys(fn ($type) => [
        $type->name => $type->establishmentTypes->map(fn ($estab) => [
            'icon' => $estab->icon,
            'label' => $estab->name,
            'size' => $estab->size,
        ])->values(),
    ]);

    return view('client.assessments.client-assessment', compact(
        'activeAssessments', 'historyAssessments', 'total', 'confirmed', 'pending', 'declined',
        'clientTypes', 'estabOptionsForWizard', 'services', 'cctvService', 'coverageProvincesByRegion'
    ));
}

    public function showClientAssessmentForm()
    {
        return view('client.assessments.assessment-form');
    }

    public function showAssessmentDetails(Assessment $assessment)
    {
        abort_unless($assessment->client_id === auth()->user()->client->id, 403);
        $assessment->load(['client.user', 'items.item', 'assessors.staff.user', 'quotation']);

        return view('client.assessments.assessment-view', compact('assessment'));
    }

    public function printAssessment(Assessment $assessment)
    {
        abort_unless($assessment->client_id === auth()->user()->client->id, 403);
        $assessment->load(['client.user', 'items.item']);

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
        $client = auth()->user()->client;

        $projects = Project::with('quotation.assessment')
            ->whereHas('quotation.assessment', fn ($q) => $q->where('client_id', $client->id))
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get();

        $total = $projects->count();
        $notStarted = $projects->where('status', 'Not Started')->count();
        $inProgress = $projects->where('status', 'In Progress')->count();
        $onHold = $projects->where('status', 'On Hold')->count();
        $completed = $projects->where('status', 'Completed')->count();

        return view('client.projects.client-project', compact(
            'projects', 'total', 'notStarted', 'inProgress', 'onHold', 'completed'
        ));
    }

    public function showProjectMonitoring(Project $project)
    {
        abort_unless($project->quotation->assessment->client_id === auth()->user()->client->id, 403);

        $project->load(
            'quotation.assessment',
            'tasks.checklistItems',
            'tasks.employee.staff.user',
            'updates.user'
        );

        return view('client.projects.project-monitoring', compact('project'));
    }

    public function showClientProfile()
    {
        $user = auth()->user();
        $client = $user->client;
        $latestAssessment = $client->assessments()->latest()->first();

        return view('client.profile', compact('user', 'client', 'latestAssessment'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $client = $user->client;

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'contact_number' => ['required', 'regex:/^09\d{9}$/'],
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'block' => 'nullable|string|max:50',
            'lot' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:150',
            'barangay' => 'required|string|max:150',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'current_password' => ['required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'contact_number.regex' => 'Contact number must be an 11-digit number starting with 09 (e.g. 09171234567).',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
        ]);

        $client->update([
            'block' => $validated['block'] ?? null,
            'lot' => $validated['lot'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'zip_code' => $validated['zip_code'] ?? null,
        ]);

        if (! empty($validated['new_password'])) {
            $user->update(['password' => $validated['new_password']]);
        }

        ActivityLogController::log(
            'Client',
            'Updated',
            'Updated profile information.',
            $user->id,
            $user->full_name
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function showClientSettings()
    {
        $user = auth()->user();
        $client = $user->client;

        return view('client.settings', compact('user', 'client'));
    }

    public function updateNotificationPreferences(Request $request)
    {
        $client = auth()->user()->client;

        $validated = $request->validate([
            'notify_assessment' => 'required|boolean',
            'notify_quotation' => 'required|boolean',
            'notify_project' => 'required|boolean',
        ]);

        $client->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated.',
        ]);
    }

    public function showActivityLogs()
    {
        $logs = ActivityLog::where('user_id', auth()->id())
            ->where('module', '!=', 'Auth')
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get();

        return view('client.activity-logs', compact('logs'));
    }

    public function showNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('client.notifications', compact('notifications'));
    }
}