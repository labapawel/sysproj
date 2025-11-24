<?php

namespace App\Filament\Resources\StudProjs\Tables;

use App\Filament\Actions\StartProjAction;
use App\Filament\Resources\UserProjs\UserprojResource;
use App\Models\Userproj;
use Filament\Actions\Action as FilamentAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
                TextColumn::make('name')
                    ->label(__('student.table.name'))
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                Filter::make('my_groups')
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
                FilamentAction::make('open_board')
                    ->label(__('student.actions.open_board') ?? 'Otwórz tablicę')
                    ->icon('heroicon-o-viewfinder-circle')
                    ->color('primary')
                    ->url(function ($record) {
                        $userId = auth()->id();

                        if (! $userId) {
                            return null;
                        }

                        $enrollment = Userproj::query()
                            ->where('user_id', $userId)
                            ->where('project_id', $record->id)
                            ->first();

                        return $enrollment ? UserprojResource::getUrl('view', ['record' => $enrollment]) : null;
                    })
                    ->visible(function ($record) {
                        $userId = auth()->id();

                        if (! $userId) {
                            return false;
                        }

                        return Userproj::query()
                            ->where('user_id', $userId)
                            ->where('project_id', $record->id)
                            ->exists();
                    })
                    ->openUrlInNewTab(),
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
