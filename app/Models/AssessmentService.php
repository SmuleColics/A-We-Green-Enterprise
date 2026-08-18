<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentService extends Model
{
    protected $fillable = ['name', 'icon', 'has_subtypes', 'sort_order', 'active'];

    protected $casts = ['has_subtypes' => 'boolean', 'active' => 'boolean'];

    public function subtypes()
    {
        return $this->hasMany(AssessmentServiceSubtype::class)->orderBy('sort_order');
    }
}
