<?php

namespace App\Filament\Resources\StudProjs\Pages;

use App\Filament\Resources\StudProjs\StudProjResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudProjs extends ListRecords
{
    protected static string $resource = StudProjResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
