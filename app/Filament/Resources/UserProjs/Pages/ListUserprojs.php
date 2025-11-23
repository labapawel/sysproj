<?php

namespace App\Filament\Resources\UserProjs\Pages;

use App\Filament\Resources\UserProjs\UserprojResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUserprojs extends ListRecords
{
    protected static string $resource = UserprojResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getTableHeading(): string
    {
        return __('student.title.active_projects') ?? 'Moje projekty';
    }

    protected function getRedirectUrl(): ?string
    {
        return Auth::check() ? parent::getRedirectUrl() : url('/');
    }
}
