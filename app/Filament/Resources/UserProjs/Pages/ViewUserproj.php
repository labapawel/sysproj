<?php

namespace App\Filament\Resources\UserProjs\Pages;

use App\Filament\Resources\UserProjs\UserprojResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewUserproj extends ViewRecord
{
    protected static string $resource = UserprojResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        abort_if($this->record->user_id !== Auth::id(), 403);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
