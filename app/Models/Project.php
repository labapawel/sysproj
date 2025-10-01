<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
