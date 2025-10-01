<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        $user = Auth::user();

        if (! $user || ! $user->active) {
            return false;
        }

        $roleValue = DB::table('users')->where('id', $user->id)->value('role');
        $isGuardian = ($roleValue & 1) === 1;
        $isAdmin = ($roleValue & 2) === 2;

        return $isGuardian || $isAdmin;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
