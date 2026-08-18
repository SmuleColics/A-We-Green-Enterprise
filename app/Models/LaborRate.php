<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaborRate extends Model
{
    protected $fillable = ['service_type', 'client_type_condition', 'rate_percent', 'active', 'updated_by'];

    protected $casts = ['rate_percent' => 'decimal:2', 'active' => 'boolean'];
}
