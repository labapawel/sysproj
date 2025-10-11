<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('admin.title.name'))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('email')
                    ->label(__('admin.title.email'))
                    ->email()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->label(__('admin.title.password'))
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->same('password_confirmation'),
                TextInput::make('password_confirmation')
                    ->password()
                    ->label(__('admin.title.password_confirmation'))
                    ->dehydrated(false)
                    ->same('password'),
                Select::make('role')
                    ->label(__('admin.title.role'))
                    ->multiple()
                    ->default([])
                    ->columnSpanFull()
                    ->options([
                        1 => __('admin.title.roles.moderator'),
                        2 => __('admin.title.roles.admin'),
                    ])
                    ->dehydrateStateUsing(fn (?array $state): array => array_map('intval', $state ?? [])),
                Select::make('groups')
                    ->label(__('admin.title.groups'))
                    ->relationship('groups', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Checkbox::make('active')
                    ->label(__('admin.title.active')),
            ]);
    }
}
