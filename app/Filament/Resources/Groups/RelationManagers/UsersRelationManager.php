<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use Illuminate\Database\Eloquent\Model;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('admin.title.group_members');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin.title.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('admin.title.email'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(__('admin.title.role'))
                    ->badge(),
                TextColumn::make('pivot.created_at')
                    ->dateTime()
                    ->label(__('admin.title.created_at'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->label(__('admin.title.add_user'))
                    ->preloadRecordSelect(),
            ])
            ->actions([
                DetachAction::make()
                    ->label(__('admin.title.delete')),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}
