<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    private const ROLE_MAP = [
        'Employee' => User::ROLE_EMPLOYEE,
        'Admin' => User::ROLE_ADMIN,
    ];

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

        return view('admin.employees.employees', compact(
            'staffMembers', 'total', 'admins', 'technicians', 'drivers'
        ));
    }

    public function availability(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'ignore_project_task_id' => 'nullable|integer|exists:project_tasks,id',
            'required_position' => 'nullable|in:technician,driver',
        ]);

        $conflicts = $employee->conflictingAssignments(
            $validated['start'],
            $validated['end'],
            $validated['ignore_project_task_id'] ?? null
        );

        return response()->json([
            'available' => $conflicts->isEmpty(),
            'conflicts' => $conflicts,
            'qualifies' => isset($validated['required_position'])
                ? $employee->qualifiesForPosition($validated['required_position'])
                : null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateStaff($request);
        $role = self::ROLE_MAP[$validated['type']];

        $staff = DB::transaction(function () use ($validated, $role) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'contact_number' => $validated['contact_number'],
                'status' => 'active',
            ]);

            $staff = Staff::create([
                'user_id' => $user->id,
                'staff_id' => Staff::generateStaffId($role),
                'date_joined' => now(),
                'block' => $validated['block'] ?? null,
                'lot' => $validated['lot'] ?? null,
                'street' => $validated['street'] ?? null,
                'barangay' => $validated['barangay'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'zip_code' => $validated['zip_code'] ?? null,
            ]);

            if ($role === User::ROLE_EMPLOYEE) {
                Employee::create([
                    'staff_id' => $staff->id,
                    'position' => $validated['position'],
                ]);
            }

            return $staff;
        });

        ActivityLogController::log(
            'Employee',
            'Created',
            "New staff member added: {$staff->user->full_name} ({$validated['type']}).",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$staff->user->full_name} added successfully.",
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $this->validateStaff($request, $staff);
        $currentTypeLabel = array_search($staff->user->role, self::ROLE_MAP, true) ?: 'Employee';
        $newRole = self::ROLE_MAP[$validated['type']];

        DB::transaction(function () use ($validated, $staff, $newRole) {
            $staff->user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'email' => $validated['email'],
                'role' => $newRole,
                ...(! empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
            ]);

            $staff->update([
                'block' => $validated['block'] ?? null,
                'lot' => $validated['lot'] ?? null,
                'street' => $validated['street'] ?? null,
                'barangay' => $validated['barangay'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'zip_code' => $validated['zip_code'] ?? null,
            ]);

            if ($newRole === User::ROLE_EMPLOYEE) {
                Employee::updateOrCreate(
                    ['staff_id' => $staff->id],
                    ['position' => $validated['position']]
                );
            } else {
                // No longer a field employee — the position record no longer applies
                $staff->employee?->delete();
            }
        });

        ActivityLogController::log(
            'Employee',
            'Updated',
            "Staff profile updated: {$staff->user->full_name}.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$staff->user->full_name}'s profile updated successfully.",
        ]);
    }

    public function archive(Staff $staff)
    {
        $staff->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Employee',
            'Archived',
            "Staff member archived: {$staff->user->full_name}.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$staff->user->full_name} moved to archive.",
        ]);
    }

    private function validateStaff(Request $request, ?Staff $staff = null): array
    {
        return $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'type' => ['required', Rule::in(array_keys(self::ROLE_MAP))],
            'position' => ['required_if:type,Employee', Rule::in([
                Employee::POSITION_DRIVER,
                Employee::POSITION_TECHNICIAN,
                Employee::POSITION_DRIVER_TECHNICIAN,
            ])],
            'contact_number' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                $staff
                    ? Rule::unique('users', 'email')->ignore($staff->user_id)
                    : Rule::unique('users', 'email'),
            ],
            // Only required on create; leave blank on edit to keep the current password
            'password' => [$staff ? 'nullable' : 'required', 'string', 'min:8'],
            'block' => 'nullable|string|max:50',
            'lot' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:150',
            'barangay' => 'required|string|max:150',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:10',
        ]);
    }
}
