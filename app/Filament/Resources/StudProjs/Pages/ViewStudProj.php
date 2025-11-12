<?php

namespace App\Filament\Resources\StudProjs\Pages;

use App\Filament\Resources\StudProjs\StudProjResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Actions\StartProjAction;

class ViewStudProj extends ViewRecord
{
    protected static string $resource = StudProjResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
            StartProjAction::make(),
        ];
    }
}
