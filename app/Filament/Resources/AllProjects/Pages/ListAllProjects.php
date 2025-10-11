<?php

namespace App\Filament\Resources\AllProjects\Pages;

use App\Filament\Resources\AllProjects\AllProjectsResource;
use Filament\Resources\Pages\ListRecords;

class ListAllProjects extends ListRecords
{
    protected static string $resource = AllProjectsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
