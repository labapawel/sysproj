<?php

namespace App\Livewire;

use App\Models\Stage;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StageTasksTable extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public Stage $stage;

    public function mount(int $stageId): void
    {
        $this->stage = Stage::with('project')->findOrFail($stageId);

        $user = Auth::user();
        abort_if(! $user, 403);

        $ownsProject = $user->id === $this->stage->project->user_id;
        $isAdmin = ((int) $user->getRawOriginal('role') & 2) === 2;

        abort_if(! $ownsProject && ! $isAdmin, 403);

        $this->mountInteractsWithTable();
        $this->cacheMountedActions($this->mountedActions);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->headerActions($this->getTableHeaderActions())
            ->actions($this->getTableActions())
            ->defaultSort('order');
    }

    public function render()
    {
        return view('livewire.stage-tasks-table');
    }

    protected function getTableQuery(): Builder
    {
        return Task::query()
            ->where('stage_id', $this->stage->id);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('admin.title.name'))
                ->searchable(),
            TextColumn::make('duration')
                ->label(__('admin.title.leadTime'))
                ->suffix(' days')
                ->sortable(),
            IconColumn::make('active')
                ->label(__('admin.title.active'))
                ->boolean(),
            TextColumn::make('updated_at')
                ->label(__('admin.title.updated_at'))
                ->since()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin.title.add_task'))
                ->form($this->taskFormSchema())
                ->mutateFormDataUsing(function (array $data): array {
                    $data['stage_id'] = $this->stage->id;

                    if (! filled($data['order'] ?? null)) {
                        $maxOrder = Task::where('stage_id', $this->stage->id)->max('order');
                        $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
                    }

                    return $data;
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('move_up')
                ->label('↑')
                ->tooltip(__('admin.title.move_up'))
                ->color('gray')
                ->action(function (Task $record) {
                    $previousTask = Task::where('stage_id', $record->stage_id)
                        ->where('order', '<', $record->order)
                        ->orderByDesc('order')
                        ->first();

                    if ($previousTask) {
                        $temp = $record->order;
                        $record->order = $previousTask->order;
                        $previousTask->order = $temp;

                        $record->save();
                        $previousTask->save();
                    }
                })
                ->visible(fn (Task $record) => Task::where('stage_id', $record->stage_id)
                    ->where('order', '<', $record->order)
                    ->exists()
                ),
            Action::make('move_down')
                ->label('↓')
                ->tooltip(__('admin.title.move_down'))
                ->color('gray')
                ->action(function (Task $record) {
                    $nextTask = Task::where('stage_id', $record->stage_id)
                        ->where('order', '>', $record->order)
                        ->orderBy('order')
                        ->first();

                    if ($nextTask) {
                        $temp = $record->order;
                        $record->order = $nextTask->order;
                        $nextTask->order = $temp;

                        $record->save();
                        $nextTask->save();
                    }
                })
                ->visible(fn (Task $record) => Task::where('stage_id', $record->stage_id)
                    ->where('order', '>', $record->order)
                    ->exists()
                ),
            EditAction::make()
                ->label(__('admin.title.edit'))
                ->form($this->taskFormSchema()),
            DeleteAction::make()
                ->label(__('admin.title.delete')),
        ];
    }

    protected function taskFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('admin.title.name'))
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->label(__('admin.title.description'))
                ->maxLength(65535),
            TextInput::make('duration')
                ->label(__('admin.title.leadTime'))
                ->numeric()
                ->suffix(' days'),
            Toggle::make('active')
                ->label(__('admin.title.active'))
                ->default(true),
        ];
    }
}
