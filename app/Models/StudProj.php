<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudProj extends Project
{
public function create(User $user): bool
{
    return false; // Wyłącza możliwość tworzenia
}

}
