<?php

namespace App\Filament\Actions;

use \Filament\Actions\Action;
use App\Models\StudProj;
use Filament\Forms\Components\TextInput;

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

            // Dodanie formularza
            ->form([
                TextInput::make('new_name')
                    ->label('Nowa nazwa')
                    ->default(fn (StudProj $record) => $record->name)
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Wprowadź nową nazwę projektu'),
            ])

            ->action(function (StudProj $record, array $data) {
                // Dostęp do wprowadzonej nazwy
                $newName = $data['new_name'];

                // Twoja logika
            //    $record->update(['name' => $newName]);

                // Powiadomienie
                \Filament\Notifications\Notification::make()
                    ->title('Sukces!')
                    ->body("Nazwa projektu została zmieniona na: {$newName}")
                    ->success()
                    ->send();
            });
    }
}
