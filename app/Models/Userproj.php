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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function projStages()
    {
        return $this->hasMany(ProjStage::class, 'userproj_id');
    }
}
