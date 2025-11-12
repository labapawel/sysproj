<?php

namespace App\Filament\Resources\StudProjs\Pages;

use App\Filament\Resources\StudProjs\StudProjResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudProj extends EditRecord
{
    protected static string $resource = StudProjResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
