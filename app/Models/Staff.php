<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id', 'staff_id', 'date_joined',
        'block', 'lot', 'street', 'barangay', 'province', 'city', 'zip_code',
        'is_archived', 'archived_at',
        'notify_assessment', 'notify_quotation', 'notify_task', 'notify_project', 'notify_checklist',
    ];

    protected $casts = [
        'date_joined' => 'date',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
        'notify_assessment' => 'boolean',
        'notify_quotation' => 'boolean',
        'notify_task' => 'boolean',
        'notify_project' => 'boolean',
        'notify_checklist' => 'boolean',
    ];

    // ── Relationships ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    // ── ID Generator ──
    public static function generateStaffId(string $role): string
    {
        $year = now()->year;

        $prefix = match ($role) {
            User::ROLE_EMPLOYEE => 'EMP',
            User::ROLE_ADMIN => 'ADM',
            default => 'STF',
        };

        $count = self::whereYear('created_at', $year)
            ->where('staff_id', 'like', "{$prefix}-%")
            ->count() + 1;

        return "{$prefix}-{$year}-".str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
