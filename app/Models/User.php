<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // ── Role Constants ──
    const ROLE_CLIENT = 'client';

    const ROLE_EMPLOYEE = 'employee';

    const ROLE_ADMIN = 'admin';

    const ROLE_SUPER_ADMIN = 'super_admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'contact_number',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ── Accessors ──
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1).substr($this->last_name, 0, 1));
    }

    // ── Role Helpers ──
    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isStaff(): bool
    {
        return in_array($this->role, [
            self::ROLE_EMPLOYEE,
            self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN,
        ]);
    }

    // ── Relationships ──
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
