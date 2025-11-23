<?php

namespace App\Filament\Resources\StudProjs\Pages;

use App\Filament\Actions\StartProjAction;
use App\Filament\Resources\StudProjs\StudProjResource;
use App\Filament\Resources\UserProjs\UserprojResource;
use App\Models\Userproj;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewStudProj extends ViewRecord
{
    protected static string $resource = StudProjResource::class;


    protected function getHeaderActions(): array
    {
        $enrollment = $this->getEnrollment();

        return [
            StartProjAction::make(),
            Action::make('open_board')
                ->label(__('student.actions.open_board') ?? 'Otwórz tablicę')
                ->icon('heroicon-o-viewfinder-circle')
                ->color('primary')
                ->url(fn () => $enrollment ? UserprojResource::getUrl('view', ['record' => $enrollment]) : null)
                ->visible(fn () => (bool) $enrollment)
                ->openUrlInNewTab(),
        ];
    }

    protected function getEnrollment(): ?Userproj
    {
        $userId = auth()->id();

        if (! $userId) {
            return null;
        }

        return Userproj::query()
            ->where('user_id', $userId)
            ->where('project_id', $this->record->id)
            ->first();
    }
}
