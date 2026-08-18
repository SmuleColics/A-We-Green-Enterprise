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
        ?int $userId = null,
        ?string $userName = null
    ): void {
        $user = $userId ?? (auth()->check() ? auth()->id() : null);
        $fullName = $userName ?? (auth()->check() ? auth()->user()->full_name : 'Unknown');

        ActivityLog::create([
            'user_id' => $user,
            'user_name' => $fullName,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }

    // ── Admin Views ──
    public function index()
    {
        // Employees only ever see their own activity — everyone else (secretary,
        // admin, super_admin) sees the full system-wide log, same as before.
        $ownOnly = auth()->user()->isEmployee();

        $logs = ActivityLog::active()
            ->with('user')
            ->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))
            ->orderByDesc('created_at')
            ->get();

        $archivedLogs = ActivityLog::archived()
            ->with('user', 'archivedBy')
            ->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))
            ->orderByDesc('archived_at')
            ->get();

        $totalToday = ActivityLog::active()->today()->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))->count();
        $totalLogs = ActivityLog::active()->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))->count();
        $activeUsers = ActivityLog::active()
            ->today()
            ->whereNotNull('user_id')
            ->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))
            ->distinct('user_id')
            ->count('user_id');
        $failedLoginsToday = ActivityLog::active()
            ->today()
            ->where('action', 'Failed Login')
            ->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))
            ->count();

        $archivableCounts = collect([30, 60, 90, 180, 365])->mapWithKeys(
            fn ($days) => [$days => ActivityLog::active()
                ->where('created_at', '<', now()->subDays($days))
                ->when($ownOnly, fn ($q) => $q->where('user_id', auth()->id()))
                ->count()]
        );

        return view('admin.admin-activity-logs', compact(
            'logs', 'archivedLogs', 'totalToday', 'totalLogs', 'activeUsers',
            'failedLoginsToday', 'archivableCounts'
        ));
    }

    public function archiveOld(Request $request)
    {
        $request->validate([
            'older_than' => 'required|in:30,60,90,180,365',
        ]);

        $days = (int) $request->older_than;
        $cutoff = now()->subDays($days);

        $affected = ActivityLog::active()
            ->where('created_at', '<', $cutoff)
            ->update([
                'is_archived' => true,
                'archived_at' => now(),
                'archived_by' => auth()->id(),
            ]);

        self::log(
            'Settings',
            'Archived',
            "Archived {$affected} activity log(s) older than {$days} days."
        );

        return back()->with('success', "{$affected} log(s) archived successfully.");
    }
}
