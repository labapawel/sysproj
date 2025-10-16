<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name', 'description', 'user_id', 'leadTime', 'active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'projects_groups')->withTimestamps();
    }
}
