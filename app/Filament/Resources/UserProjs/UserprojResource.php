<?php

namespace App\Filament\Resources\UserProjs;

use App\Filament\Resources\UserProjs\Pages\ListUserprojs;
use App\Filament\Resources\UserProjs\Pages\ViewUserproj;
use App\Models\Userproj;
use App\Services\EnrollmentBoardService;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserprojResource extends Resource
{
    protected static ?string $model = Userproj::class;

    protected static ?string $slug = 'my-projects';

    public static function getNavigationGroup(): ?string
    {
        return __('student.title.student_panel');
    }

    public static function getNavigationLabel(): string
    {
        return __('student.title.active_projects') ?? 'Moje projekty';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $userId = Auth::id();

                if ($userId) {
                    $query->where('user_id', $userId);
                }
            })
            ->columns([
                TextColumn::make('name')
                    ->label(__('student.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_cache.stages_completed')
                    ->label(__('student.table.stage_progress') ?? 'Ukończone etapy')
                    ->formatStateUsing(function ($state, Userproj $record) {
                        $total = data_get($record->status_cache, 'stages_total', 0);
                        $completed = data_get($record->status_cache, 'stages_completed', 0);

                        return $total ? sprintf('%d / %d', $completed, $total) : '0 / 0';
                    }),
                TextColumn::make('status_cache.progress')
                    ->label(__('student.table.progress') ?? 'Postęp')
                    ->formatStateUsing(fn ($state) => ($state ?? 0) . '%')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->since()
                    ->label(__('admin.title.updated_at')),
            ])
            ->filters([
                Filter::make('completed')
                    ->label(__('student.filter.completed') ?? 'Ukończone')
                    ->query(fn (Builder $query) => $query->where('status', 2)),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                ViewEntry::make('board')
                    ->view('filament.resources.userprojs.board')
                    ->viewData(fn (Userproj $record) => [
                        'board' => app(EnrollmentBoardService::class)->buildBoard($record),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserprojs::route('/'),
            'view' => ViewUserproj::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
