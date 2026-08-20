<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    // Read-only, system-wide client directory — full details (employees
    // already see the same client data via the Assessments module), but
    // no create/edit/archive actions and no financial/quotation data here.
    public function index()
    {
        $clients = Client::with(['user', 'assessments' => fn ($q) => $q->latest()])
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($client) {
                $latest = $client->assessments->first();
                $client->derived_type = $latest->client_type ?? null;
                $client->derived_service = $latest ? implode(', ', $latest->services ?? []) : null;

                return $client;
            });

        $total = $clients->count();
        $residential = $clients->where('derived_type', 'Residential')->count();
        $commercial = $clients->where('derived_type', 'Commercial')->count();
        $government = $clients->where('derived_type', 'Government/LGU')->count();

        return view('employee.clients', compact(
            'clients', 'total', 'residential', 'commercial', 'government'
        ));
    }

    public function show(Client $client)
    {
        $client->load(['user', 'assessments' => fn ($q) => $q->latest()]);
        $latest = $client->assessments->first();

        $addressParts = [];
        if ($client->block) {
            $addressParts[] = "Blk {$client->block}";
        }
        if ($client->lot) {
            $addressParts[] = "Lot {$client->lot}";
        }
        if ($client->street) {
            $addressParts[] = "{$client->street} St.";
        }
        if ($client->barangay) {
            $addressParts[] = $client->barangay;
        }
        if ($client->city) {
            $addressParts[] = $client->city;
        }
        if ($client->province) {
            $addressParts[] = $client->province;
        }
        if ($client->zip_code) {
            $addressParts[] = $client->zip_code;
        }

        return response()->json([
            'success' => true,
            'client' => [
                'id' => $client->id,
                'client_id' => $client->client_id,
                'firstName' => $client->user->first_name,
                'lastName' => $client->user->last_name,
                'name' => $client->user->full_name,
                'contact' => $client->user->contact_number,
                'email' => $client->user->email,
                'status' => $client->user->status,
                'type' => $latest->client_type ?? null,
                'service' => $latest ? implode(', ', $latest->services ?? []) : null,
                'address' => implode(', ', $addressParts),
                'joined' => $client->created_at->format('M j, Y'),
                'assessments_count' => $client->assessments->count(),
            ],
        ]);
    }
}
