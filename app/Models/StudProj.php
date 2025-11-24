<?php

namespace App\Models;

class StudProj extends Project
{
    public function create(User $user): bool
    {
        return false; // Wyłącza możliwość tworzenia
    }
}
