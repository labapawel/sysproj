<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjStage extends Model
{
    protected $table = 'proj_stages';

    protected $fillable = [
        'name',
        'description',
        'order',
        'duration',
        'active',
        'settings',
        'tasks',
        'userproj_id',
        'stage_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'tasks' => 'array',
    ];

    public function userproj()
    {
        return $this->belongsTo(Userproj::class, 'userproj_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }
}
