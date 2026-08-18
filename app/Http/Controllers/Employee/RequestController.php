<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Assessment;

class RequestController extends Controller
{
    // Read-only, system-wide view of client requests — same data as the admin
    // Assessment Requests page, without the confirm/decline/archive actions.
    public function index()
    {
        $assessments = Assessment::with(['client.user', 'assessors.staff.user'])
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get();

        $total = $assessments->count();
        $confirmed = $assessments->where('status', 'Confirmed')->count();
        $pending = $assessments->where('status', 'Pending')->count();
        $declined = $assessments->where('status', 'Declined')->count();

        return view('employee.requests', compact(
            'assessments', 'total', 'confirmed', 'pending', 'declined'
        ));
    }
}
