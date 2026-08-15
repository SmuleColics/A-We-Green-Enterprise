<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    protected $fillable = ['project_id', 'user_id', 'body', 'images', 'is_archived', 'archived_at'];
    protected $casts = ['images' => 'array', 'is_archived' => 'boolean', 'archived_at' => 'datetime'];

    public function project() { return $this->belongsTo(Project::class); }
    public function user() { return $this->belongsTo(User::class); }
}
