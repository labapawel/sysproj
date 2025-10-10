<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\Stage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class StagesRelationManager extends RelationManager
{
    protected static string $relationship = 'stages';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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
                    ->suffix('days')
                    ->required(),

                Toggle::make('active')
                    ->label(__('admin.title.active'))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label(__('admin.title.order'))
                    ->sortable(),

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

                TextColumn::make('tasks_count')
                    ->counts('tasks')
                    ->label(__('admin.title.tasks')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $maxOrder = Stage::where('project_id', $this->getOwnerRecord()->id)->max('order');
                        $data['order'] = $maxOrder ? $maxOrder + 1 : 1;

                        return $data;
                    }),
            ])
            ->actions([
                Action::make('move_up')
                    ->label('↑')
                    ->tooltip(__('admin.title.move_up'))
                    ->color('gray')
                    ->action(function (Stage $record) {
                        $previousStage = Stage::where('project_id', $record->project_id)
                            ->where('order', '<', $record->order)
                            ->orderByDesc('order')
                            ->first();

                        if ($previousStage) {
                            $temp = $record->order;
                            $record->order = $previousStage->order;
                            $previousStage->order = $temp;

                            $record->save();
                            $previousStage->save();
                        }
                    })
                    ->visible(fn (Stage $record) => Stage::where('project_id', $record->project_id)
                        ->where('order', '<', $record->order)
                        ->exists()
                    ),
                Action::make('move_down')
                    ->label('↓')
                    ->tooltip(__('admin.title.move_down'))
                    ->color('gray')
                    ->action(function (Stage $record) {
                        $nextStage = Stage::where('project_id', $record->project_id)
                            ->where('order', '>', $record->order)
                            ->orderBy('order')
                            ->first();

                        if ($nextStage) {
                            $temp = $record->order;
                            $record->order = $nextStage->order;
                            $nextStage->order = $temp;

                            $record->save();
                            $nextStage->save();
                        }
                    })
                    ->visible(fn (Stage $record) => Stage::where('project_id', $record->project_id)
                        ->where('order', '>', $record->order)
                        ->exists()
                    ),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('manage_tasks')
                    ->label(__('admin.title.manage_tasks'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('primary')
                    ->modalHeading(fn (Stage $record) => __('admin.title.tasks_for_stage', ['stage' => $record->name]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('admin.title.close'))
                    ->modalWidth('7xl')
                    ->modalContent(fn (Stage $record): View => view(
                        'filament.components.stage-tasks-modal',
                        ['stage' => $record]
                    )),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
