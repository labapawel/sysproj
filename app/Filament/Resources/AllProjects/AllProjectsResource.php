<?php

namespace App\Filament\Resources\AllProjects;

use App\Filament\Resources\AllProjects\Pages\ListAllProjects;
use App\Models\AllProject;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllProjectsResource extends Resource
{
    protected static ?string $model = AllProject::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?int $navigationSort = 20;

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user && ((int) $user->getRawOriginal('role') & 1) === 1;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.title.teacher_panel');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.title.all_projects');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('stages'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin.title.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label(__('admin.title.project_owner'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stages_count')
                    ->label(__('admin.title.stages'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('admin.title.created_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('cloneProject')
                    ->label(__('admin.actions.clone_project'))
                    ->icon(Heroicon::OutlinedDocumentDuplicate)
                    ->requiresConfirmation()
                    ->color('primary')
                    ->action(function (AllProject $record) {
                        $user = Auth::user();

                        if (! $user) {
                            return;
                        }

                        $newProject = DB::transaction(function () use ($record, $user) {
                            $project = Project::create([
                                'name' => static::generateCloneName($record->name, $user->id),
                                'description' => $record->description,
                                'user_id' => $user->id,
                                'leadTime' => $record->leadTime,
                                'active' => $record->active,
                            ]);

                            $record->stages()
                                ->with('tasks')
                                ->orderBy('order')
                                ->get()
                                ->each(function ($stage) use ($project) {
                                    $newStage = $project->stages()->create([
                                        'name' => $stage->name,
                                        'description' => $stage->description,
                                        'order' => $stage->order,
                                        'duration' => $stage->duration,
                                        'active' => $stage->active,
                                    ]);

                                    $stage->tasks
                                        ->sortBy('order')
                                        ->each(function ($task) use ($newStage) {
                                            $newStage->tasks()->create([
                                                'name' => $task->name,
                                                'description' => $task->description,
                                                'order' => $task->order,
                                                'duration' => $task->duration,
                                                'active' => $task->active,
                                            ]);
                                        });
                                });

                            return $project;
                        });

                        Notification::make()
                            ->success()
                            ->title(__('admin.notifications.project_cloned_title'))
                            ->body(__('admin.notifications.project_cloned_body', ['name' => $newProject->name]))
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAllProjects::route('/'),
        ];
    }

    protected static function generateCloneName(string $baseName, int $userId): string
    {
        $copyBase = "{$baseName} (" . __('admin.title.copy_suffix') . ')';
        $candidate = $copyBase;
        $index = 2;

        while (Project::where('user_id', $userId)->where('name', $candidate)->exists()) {
            $candidate = "{$copyBase} {$index}";
            $index++;
        }

        return $candidate;
    }
}
