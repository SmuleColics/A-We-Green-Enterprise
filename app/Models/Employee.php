<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    const POSITION_DRIVER = 'driver';

    const POSITION_TECHNICIAN = 'technician';

    const POSITION_DRIVER_TECHNICIAN = 'driver_technician';

    protected $fillable = [
        'staff_id',
        'position',
    ];

    // ── Relationships ──
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_assessor');
    }

    // ── Accessors ──
    public function getFullNameAttribute()
    {
        return $this->staff?->user?->full_name ?? 'Unknown';
    }
}
