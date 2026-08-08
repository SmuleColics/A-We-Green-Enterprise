<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'client_id', 'client_type', 'establishment_type', 'establishment_size',
        'preferred_date', 'time_slot', 'services', 'cctv_subtype',
        'notes', 'status', 'cancellation_reason',
    ];

    protected $casts = [
        'services' => 'array',
        'preferred_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
