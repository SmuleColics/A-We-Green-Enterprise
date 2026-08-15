<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
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

        return view('admin.clients.clients', compact(
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
                'block' => $client->block,
                'lot' => $client->lot,
                'street' => $client->street,
                'barangay' => $client->barangay,
                'city' => $client->city,
                'province' => $client->province,
                'zip_code' => $client->zip_code,
                'address' => implode(', ', $addressParts),
                'joined' => $client->created_at->format('M j, Y'),
                'assessments_count' => $client->assessments->count(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'block' => 'nullable|string|max:255',
            'lot' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        [$user, $client] = DB::transaction(function () use ($validated) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => $validated['password'],   // cast hashes this automatically
                'role' => User::ROLE_CLIENT,
                'contact_number' => $validated['contact_number'] ?? null,
                'status' => 'active',
            ]); 

            $client = Client::create([
                'user_id' => $user->id,
                'client_id' => Client::generateClientId(),
                'block' => $validated['block'] ?? null,
                'lot' => $validated['lot'] ?? null,
                'street' => $validated['street'] ?? null,
                'barangay' => $validated['barangay'] ?? null,
                'city' => $validated['city'] ?? null,
                'province' => $validated['province'] ?? null,
                'zip_code' => $validated['zip_code'] ?? null,
            ]);

            return [$user, $client];
        });

        ActivityLogController::log(
            'Client',
            'Created',
            "New client account created by admin: {$user->full_name} ({$user->email}) [{$client->client_id}].",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Client {$user->full_name} ({$client->client_id}) created successfully.",
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$client->user_id,
            'contact_number' => 'nullable|string|max:20',
            'block' => 'nullable|string|max:255',
            'lot' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $client->user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'] ?? null,
        ]);

        $client->update([
            'block' => $validated['block'] ?? null,
            'lot' => $validated['lot'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'] ?? null,
            'city' => $validated['city'] ?? null,
            'province' => $validated['province'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
        ]);

        ActivityLogController::log(
            'Client',
            'Updated',
            "Client {$client->client_id} ({$client->user->full_name}) updated.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Client {$client->client_id} updated successfully.",
        ]);
    }

    public function archive(Client $client)
    {
        $client->update(['is_archived' => true, 'archived_at' => now()]);

        ActivityLogController::log(
            'Client', 'Archived',
            "Client {$client->client_id} ({$client->user->full_name}) archived.",
            Auth::id(), Auth::user()->full_name
        );

        return response()->json(['success' => true, 'message' => "Client {$client->client_id} moved to archive."]);
    }

    public function unarchive(Client $client)
    {
        $client->update(['is_archived' => false, 'archived_at' => null]);

        ActivityLogController::log(
            'Client', 'Restored',
            "Client {$client->client_id} ({$client->user->full_name}) restored from archive.",
            Auth::id(), Auth::user()->full_name
        );

        return response()->json(['success' => true, 'message' => "Client {$client->client_id} restored."]);
    }

    public function archivedPage()
    {
        $clients = Client::with(['user', 'assessments' => fn ($q) => $q->latest()])
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
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

        return view('admin.clients.archive-clients', compact(
            'clients', 'total', 'residential', 'commercial', 'government'
        ));
    }
}