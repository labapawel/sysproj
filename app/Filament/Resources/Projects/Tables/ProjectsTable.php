<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin.title.name'))

                    ->searchable(),
                TextColumn::make('user.name')
                    ->label(__('admin.title.user'))
                // ->numeric()
                // ->sortable()
                ,
                TextColumn::make('leadTime')
                    ->label(__('admin.title.leadTime'))
                    ->searchable(),
                TextColumn::make('groups.name')
                    ->label(__('admin.title.groups'))
                    ->wrap()
                    ->formatStateUsing(fn ($state) => collect(Arr::wrap($state))->filter()->implode(', '))
                    ->placeholder('—'),
                IconColumn::make('active')
                    ->label(__('admin.title.active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('admin.title.created_at'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('admin.title.updated_at'))
                    ->toggleable(isToggledHiddenByDefault: true),
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
