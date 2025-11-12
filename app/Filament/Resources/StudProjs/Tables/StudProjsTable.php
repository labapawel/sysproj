<?php

namespace App\Filament\Resources\StudProjs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use App\Filament\Actions\StartProjAction;
use Filament\Tables\Table;

class StudProjsTable
{



    public static function configure(Table $table): Table
    {
        $user = auth()->user();
        $userGroup = $user ? $user->groups()->pluck('id')->toArray() : [];
        // enforce "my groups" filter at query level so it cannot be turned off

        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label(__('student.table.name'))
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
            \Filament\Tables\Filters\Filter::make('my_groups')
                ->label(__('student.filter.mygroups'))
                ->query(function ($query) use ($userGroup) {
                    $query->whereHas('groups', function ($q) use ($userGroup) {
                        $q->whereIn('id', $userGroup);
                    });
                })
                ->default(),
            ])
            ->recordActions([
                ViewAction::make(),
                StartProjAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
        public static function canCreate(): bool
        {
            return false;
        }
        protected function getActions(): array
{
    return [];
}
}
