<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use App\Services\AssessmentConfigService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_type' => 'required|string|max:100',
            'establishment_type' => 'required|string|max:150',
            'establishment_size' => 'required|in:small,large',
            'preferred_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:Morning,Afternoon,Full Day',
            'services' => 'required|array|min:1|max:2',
            'services.*' => 'required|string|max:100',
            'cctv_subtype' => 'nullable|array',
            'cctv_subtype.*' => 'required|string|max:50',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'contact_number' => ['required', 'regex:/^09\d{9}$/'],
            'email' => 'required|email',
'block' => 'required|string|max:50',
            'lot' => 'required|string|max:50',
            'street' => 'required|string|max:150',
            'barangay' => 'required|string|max:150',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'notes' => 'nullable|string|max:1000',
        ], [
            'contact_number.regex' => 'Contact number must be an 11-digit number starting with 09 (e.g. 09171234567).',
            'services.max' => 'You can select up to 2 services per booking.',
        ]);

        foreach ($validated['services'] as $service) {
            if (! AssessmentConfigService::isValidService($service)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a valid service.',
                ], 422);
            }
        }

        if (in_array('CCTV Setup', $validated['services']) && empty($validated['cctv_subtype'])) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a CCTV service type.',
            ], 422);
        }

        foreach ($validated['cctv_subtype'] ?? [] as $subtype) {
            if (! AssessmentConfigService::isValidSubtype('CCTV Setup', $subtype)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a valid CCTV service type.',
                ], 422);
            }
        }

        if (! AssessmentConfigService::isWorkingDay(Carbon::parse($validated['preferred_date']))) {
            return response()->json([
                'success' => false,
                'message' => 'We\'re closed on the selected date. Please choose another day.',
            ], 422);
        }

        if (! AssessmentConfigService::isSlotAvailable($validated['preferred_date'], $validated['time_slot'])) {
            return response()->json([
                'success' => false,
                'message' => 'That date and time slot just got booked. Please choose another.',
            ], 422);
        }

        if (! AssessmentConfigService::isValidClientType($validated['client_type'])) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid client type.',
            ], 422);
        }

        if (! AssessmentConfigService::isValidEstablishment($validated['client_type'], $validated['establishment_type'])) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid establishment type for the chosen client type.',
            ], 422);
        }

        if (! AssessmentConfigService::isValidProvince($validated['province'])) {
            return response()->json([
                'success' => false,
                'message' => 'We don\'t currently serve the selected province.',
            ], 422);
        }

        $user = auth()->user();
        $client = $user->client;

        // Save the location/details to the client's profile for future re-use
        $client->update([
            'block' => $validated['block'] ?? $client->block,
            'lot' => $validated['lot'] ?? $client->lot,
            'street' => $validated['street'] ?? $client->street,
            'barangay' => $validated['barangay'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'zip_code' => $validated['zip_code'] ?? $client->zip_code,
        ]);

        if ($validated['contact_number'] !== $user->contact_number) {
            $user->update(['contact_number' => $validated['contact_number']]);
        }

        $bookingGroupId = (string) Str::uuid();

        $assessments = DB::transaction(function () use ($validated, $client, $bookingGroupId) {
            return collect($validated['services'])->map(function ($service) use ($validated, $client, $bookingGroupId) {
                return Assessment::create([
                    'client_id' => $client->id,
                    'booking_group_id' => $bookingGroupId,
                    'client_type' => $validated['client_type'],
                    'establishment_type' => $validated['establishment_type'],
                    'establishment_size' => $validated['establishment_size'],
                    'preferred_date' => $validated['preferred_date'],
                    'time_slot' => $validated['time_slot'],
                    'services' => [$service],
                    'cctv_subtype' => $service === 'CCTV Setup' ? ($validated['cctv_subtype'] ?? null) : null,
                    'notes' => $validated['notes'] ?? null,
                    'status' => 'Pending',
                ]);
            });
        });

        $serviceList = implode(', ', $validated['services']);
        $idList = $assessments->pluck('id')->implode(', #');
        $firstAssessment = $assessments->first();

        ActivityLogController::log(
            'Assessment',
            'Created',
            "{$user->full_name} submitted an assessment request for {$serviceList} (Assessment #{$idList}) on {$firstAssessment->preferred_date->format('M j, Y')}.",
            $user->id,
            $user->full_name
        );

        NotificationController::notify(
            module: 'Assessment',
            title: 'New assessment request',
            message: "{$user->full_name} — {$serviceList}, {$firstAssessment->preferred_date->format('M j')}",
            recipientRole: ['admin', 'secretary', 'super_admin'],
            notifiable: $firstAssessment
        );

        return response()->json([
            'success' => true,
            'message' => 'Your assessment request has been submitted.',
            'assessment_ids' => $assessments->pluck('id'),
        ]);
    }

    public function cancel(Request $request, Assessment $assessment)
    {
        abort_unless($assessment->client_id === auth()->user()->client->id, 403);

        $validated = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $assessment->update([
            'status' => 'Cancelled',
            'cancellation_reason' => $validated['reason'],
        ]);

        ActivityLogController::log(
            'Assessment',
            'Updated',
            "{$assessment->client->user->full_name} cancelled assessment request #{$assessment->id}. Reason: {$validated['reason']}",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Request #{$assessment->id} cancelled successfully.",
        ]);
    }

    public function availability(Request $request)
    {
        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $assessments = Assessment::whereBetween('preferred_date', [$start, $end])
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->get(['id', 'booking_group_id', 'preferred_date', 'time_slot'])
            ->groupBy(fn ($a) => $a->preferred_date->format('Y-m-d').'|'.($a->booking_group_id ?? 'row-'.$a->id))
            ->map->first();

        $counts = [];
        foreach ($assessments as $a) {
            $date = $a->preferred_date->format('Y-m-d');
            $counts[$date] ??= ['morning' => 0, 'afternoon' => 0];

            if ($a->time_slot === 'Full Day') {
                $counts[$date]['morning']++;
                $counts[$date]['afternoon']++;
            } elseif ($a->time_slot === 'Morning') {
                $counts[$date]['morning']++;
            } elseif ($a->time_slot === 'Afternoon') {
                $counts[$date]['afternoon']++;
            }
        }

        $max = AssessmentConfigService::maxBookingsPerSlot();
        $availability = collect($counts)->map(fn ($c) => [
            'morning' => $c['morning'] >= $max,
            'afternoon' => $c['afternoon'] >= $max,
        ])->all();

        $blockedDates = array_values(array_filter(
            AssessmentConfigService::blockedDateStrings(),
            fn ($d) => $d >= $start->format('Y-m-d') && $d <= $end->format('Y-m-d')
        ));

        return response()->json([
            'dates' => $availability,
            'workingDays' => AssessmentConfigService::workingDays(),
            'blockedDates' => $blockedDates,
        ]);
    }
}