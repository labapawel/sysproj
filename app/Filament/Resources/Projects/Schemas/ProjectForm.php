<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('admin.title.name'))
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->label(__('admin.title.description')),

                TextInput::make('leadTime')
                    ->label(__('admin.title.leadTime'))
                    ->required(),
                Select::make('groups')
                    ->label(__('admin.title.groups'))
                    ->relationship('groups', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->label(__('admin.title.active'))
                    ->default(true)
                    ->required(),
            ]);
    }
}
