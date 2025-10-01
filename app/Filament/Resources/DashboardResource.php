<?php

namespace App\Filament\Resources;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DashboardResource extends Resource
{
    protected static ?string $model = null;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.title.dashboard');
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user && ((int) $user->getRawOriginal('role') === 0);
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.title.dashboard');
    }

    public static function getModelLabel(): string
    {
        return __('admin.title.dashboard');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [];
    }
}
