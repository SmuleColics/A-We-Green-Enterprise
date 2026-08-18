<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverageProvince extends Model
{
    protected $fillable = ['region', 'province', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];
}
