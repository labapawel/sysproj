<?php

namespace App\Filament\Resources\StudProjs;

use App\Filament\Resources\StudProjs\Pages\CreateStudProj;
use App\Filament\Resources\StudProjs\Pages\EditStudProj;
use App\Filament\Resources\StudProjs\Pages\ListStudProjs;
use App\Filament\Resources\StudProjs\Pages\ViewStudProj;
use App\Filament\Resources\StudProjs\Schemas\StudProjForm;
use App\Filament\Resources\StudProjs\Schemas\StudProjInfolist;
use App\Filament\Resources\StudProjs\Tables\StudProjsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\StudProj;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;


class StudProjResource extends Resource
{
    protected static ?string $model = StudProj::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;



    public static function getNavigationGroup(): ?string
    {
        return __('student.title.student_panel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('student.title.projects');
    }

    public static function getModelLabel(): string
    {
        return __('student.title.projects');
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudProjInfolist::configure($schema)
        ->schema([
                    TextEntry::make('name')
                        ->label(__('student.table.name'))
                         ->columnSpanFull()
                         ->color('primary'),
                    TextEntry::make('description')
                        ->label(__('student.table.description')) ->color('gray'),
                    // Relacja stages jako lista
                    RepeatableEntry::make('stages')
                                ->label(__('student.table.stages')) // lub 'Etapy'
                                ->schema([
                                    TextEntry::make('name')
                                        ->columnSpanFull()
                                        ->label(__('student.table.name')),
                                    TextEntry::make('description')
                                        ->columnSpanFull()
                                        ->label(__('student.table.description'))
                                        // ->color('gray'),
                                ])
                                // ->columns(2) // opcjonalnie: 2 kolumny dla name i description
                                ->columnSpanFull()
                                ->grid(2),
                ]);
    }

    public static function table(Table $table): Table
    {
        return StudProjsTable::configure($table);
    }

        public static function canCreate(): bool
        {
            return false;
        }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => ListStudProjs::route('/'),
            // 'create' => CreateStudProj::route('/create'),
            'view' => ViewStudProj::route('/{record}'),
            // 'edit' => EditStudProj::route('/{record}/edit'),
        ];
    }
}
