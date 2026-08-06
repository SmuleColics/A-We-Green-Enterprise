<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // ── Static helper — call this from any controller ──
    public static function log(
        string $module,
        string $action,
        string $description,
        ?int   $userId   = null,
        ?string $userName = null
    ): void {
        $user     = $userId   ?? (auth()->check() ? auth()->id()             : null);
        $fullName = $userName ?? (auth()->check() ? auth()->user()->full_name : 'Unknown');

        ActivityLog::create([
            'user_id'     => $user,
            'user_name'   => $fullName,
            'module'      => $module,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }

    // ── Admin Views ──
    public function index()
    {
        $logs = ActivityLog::active()
            ->orderByDesc('created_at')
            ->get();

        $totalToday  = ActivityLog::active()->today()->count();
        $totalLogs   = ActivityLog::active()->count();
        $activeUsers = ActivityLog::active()
            ->today()
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.activity-logs.index', compact(
            'logs', 'totalToday', 'totalLogs', 'activeUsers'
        ));
    }

    public function archived()
    {
        $logs = ActivityLog::archived()
            ->orderByDesc('archived_at')
            ->get();

        return view('admin.activity-logs.archive', compact('logs'));
    }

    public function archiveOld(Request $request)
    {
        $request->validate([
            'older_than' => 'required|in:30,60,90,180,365',
        ]);

        $days   = (int) $request->older_than;
        $cutoff = now()->subDays($days);

        $affected = ActivityLog::active()
            ->where('created_at', '<', $cutoff)
            ->update([
                'is_archived' => true,
                'archived_at' => now(),
            ]);

        self::log(
            'Settings',
            'Archived',
            "Archived {$affected} activity log(s) older than {$days} days."
        );

        return back()->with('success', "{$affected} log(s) archived successfully.");
    }
}