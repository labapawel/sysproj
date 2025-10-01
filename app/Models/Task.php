<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['name', 'description', 'stage_id', 'order', 'duration', 'active'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
