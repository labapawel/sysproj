<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userproj extends Model
{
    protected $table = 'userprojs';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'active',
        'status',
        'user_id',
        'project_id',
        'current_stage_id',
        'started_at',
        'completed_at',
        'is_overdue',
        'status_cache',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_overdue' => 'boolean',
        'status_cache' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currentStage()
    {
        return $this->belongsTo(ProjStage::class, 'current_stage_id');
    }

    public function projStages()
    {
        return $this->hasMany(ProjStage::class, 'userproj_id');
    }
}
