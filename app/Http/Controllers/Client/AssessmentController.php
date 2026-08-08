<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_type' => 'required|in:Residential,Subdivision,Commercial,Government,Agricultural,Institutional',
            'establishment_type' => 'required|string|max:150',
            'establishment_size' => 'required|in:small,large',
            'preferred_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:Morning,Afternoon,Full Day',
            'services' => 'required|array|min:1',
            'services.*' => 'in:CCTV Setup,Solar Setup,Street Light,Public Address',
            'cctv_subtype' => 'nullable|string|max:50',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email',
            'block' => 'nullable|string|max:50',
            'lot' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:150',
            'barangay' => 'required|string|max:150',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        if (in_array('CCTV Setup', $validated['services']) && empty($validated['cctv_subtype'])) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a CCTV service type.',
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

        $assessment = Assessment::create([
            'client_id' => $client->id,
            'client_type' => $validated['client_type'],
            'establishment_type' => $validated['establishment_type'],
            'establishment_size' => $validated['establishment_size'],
            'preferred_date' => $validated['preferred_date'],
            'time_slot' => $validated['time_slot'],
            'services' => $validated['services'],
            'cctv_subtype' => $validated['cctv_subtype'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'Pending',
        ]);

        $serviceList = implode(', ', $validated['services']);

        ActivityLogController::log(
            'Assessment',
            'Created',
            "{$user->full_name} submitted an assessment request for {$serviceList} on {$assessment->preferred_date->format('M j, Y')}.",
            $user->id,
            $user->full_name
        );

        NotificationController::notify(
            module: 'Assessment',
            title: 'New assessment request',
            message: "{$user->full_name} — {$serviceList}, {$assessment->preferred_date->format('M j')}",
            recipientRole: ['admin', 'secretary', 'super_admin'],
            notifiable: $assessment
        );

        return response()->json([
            'success' => true,
            'message' => 'Your assessment request has been submitted.',
            'assessment_id' => $assessment->id,
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
            ->get(['preferred_date', 'time_slot']);

        $availability = [];
        foreach ($assessments as $a) {
            $date = $a->preferred_date->format('Y-m-d');
            $availability[$date] ??= ['morning' => false, 'afternoon' => false];

            if ($a->time_slot === 'Full Day') {
                $availability[$date]['morning'] = true;
                $availability[$date]['afternoon'] = true;
            } elseif ($a->time_slot === 'Morning') {
                $availability[$date]['morning'] = true;
            } elseif ($a->time_slot === 'Afternoon') {
                $availability[$date]['afternoon'] = true;
            }
        }

        return response()->json($availability);
    }
}
