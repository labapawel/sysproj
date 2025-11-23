<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjStage extends Model
{
    protected $table = 'proj_stages';

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'name',
        'description',
        'order',
        'duration',
        'active',
        'status',
        'started_at',
        'completed_at',
        'is_overdue',
        'status_cache',
        'settings',
        'tasks',
        'userproj_id',
        'stage_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'tasks' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_overdue' => 'boolean',
        'status_cache' => 'array',
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
