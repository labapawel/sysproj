<?php

namespace App\Models;

class AllProject extends Project
{
    protected $table = 'projects';

    public function stages()
    {
        return $this->hasMany(Stage::class, 'project_id');
    }
}
