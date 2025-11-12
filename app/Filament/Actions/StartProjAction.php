<?php

namespace App\Filament\Actions;

use \Filament\Actions\Action;
use App\Models\StudProj;

class StartProjAction
{
    public static function make(): Action
    {
        return Action::make('custom_action')
            ->label(__('student.title.start_project'))
            ->icon('heroicon-o-sparkles')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Potwierdzenie')
            ->modalDescription('Czy na pewno chcesz wykonać tę akcję?')
            ->action(function (StudProj $record) {
                // Twoja logika tutaj
                $record->update(['status' => 'completed']);

                // Możesz dodać powiadomienie
                \Filament\Notifications\Notification::make()
                    ->title('Sukces!')
                    ->success()
                    ->send();
            });
    }
}
