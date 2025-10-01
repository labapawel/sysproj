<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('admin.title.name')),
                TextColumn::make('email')
                    ->label(__('admin.title.email'))
                    ->searchable(),

                TextColumn::make('role')
                    ->badge()
                    ->label(__('admin.title.role')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('admin.title.created_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label(__('admin.title.updated_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                CheckboxColumn::make('active')
                    ->label(__('admin.title.active'))
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
