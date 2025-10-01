<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\User;

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
                // pole wyb. user-a, domyślnie zalogowany user
                Select::make('user_id')
                    ->label(__('admin.title.user'))
                    ->options(User::where('active', true)->all()->pluck('name', 'id'))
                    ->default(auth()->user()->id)
                    ->required(),

                TextInput::make('leadTime')
                    ->label(__('admin.title.leadTime'))
                    ->required(),
                Toggle::make('active')
                    ->label(__('admin.title.active'))
                    ->default(true)
                    ->required(),
            ]);
    }
}
