<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $staff = auth()->user()->staff;
        abort_unless($staff, 404);

        return view('employee.settings', compact('staff'));
    }

    public function updateNotificationPreferences(Request $request)
    {
        $staff = auth()->user()->staff;
        abort_unless($staff, 404);

        $validated = $request->validate([
            'notify_assessment' => 'required|boolean',
            'notify_quotation' => 'required|boolean',
            'notify_task' => 'required|boolean',
            'notify_project' => 'required|boolean',
            'notify_checklist' => 'required|boolean',
        ]);

        $staff->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated.',
        ]);
    }
}
