<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Staff;
use App\Models\User;

class StaffController extends Controller
{
    // Read-only staff directory — same roster as the admin Employees page,
    // trimmed to the list only (no contact/address details, no manage actions).
    public function index()
    {
        $staffMembers = Staff::with(['user', 'employee'])
            ->where('is_archived', false)
            ->whereHas('user', fn ($q) => $q->whereIn('role', [
                User::ROLE_EMPLOYEE,
                User::ROLE_ADMIN,
            ]))
            ->orderByDesc('created_at')
            ->get();

        $total = $staffMembers->count();
        $admins = $staffMembers->filter(fn ($s) => $s->user->role === User::ROLE_ADMIN)->count();

        $technicians = $staffMembers->filter(
            fn ($s) => in_array($s->employee?->position, [
                Employee::POSITION_TECHNICIAN,
                Employee::POSITION_DRIVER_TECHNICIAN,
            ])
        )->count();

        $drivers = $staffMembers->filter(
            fn ($s) => in_array($s->employee?->position, [
                Employee::POSITION_DRIVER,
                Employee::POSITION_DRIVER_TECHNICIAN,
            ])
        )->count();

        return view('employee.employees', compact(
            'staffMembers', 'total', 'admins', 'technicians', 'drivers'
        ));
    }
}
