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

                TextInput::make('order')
                    ->label(__('admin.title.order'))
                    ->numeric()
                    ->default(function () {
                        return Stage::where('project_id', $this->getOwnerRecord()->id)->max('order') + 1 ?? 1;
                    }),

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
                    ->label('Tasks'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('move_up')
                    ->label('↑')
                    ->tooltip('Move Up')
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
                    ->tooltip('Move Down')
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
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
