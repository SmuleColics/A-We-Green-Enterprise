<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingService extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'features', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function featureList(): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $this->features ?? ''))));
    }
}
