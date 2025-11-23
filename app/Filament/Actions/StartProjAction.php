<?php

namespace App\Filament\Actions;

use App\Filament\Resources\UserProjs\UserprojResource;
use App\Models\StudProj;
use App\Models\Userproj;
use App\Services\ProjectEnrollmentService;
use Filament\Actions\Action as FilamentAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StartProjAction
{
    public static function make(): FilamentAction
    {
        $modalDescription = static::translation(
            'student.title.start_project_description',
            'Utwórz prywatną kopię projektu wraz z etapami i zadaniami.'
        );

        return FilamentAction::make('start_project')
            ->label(__('student.title.start_project'))
            ->icon('heroicon-o-sparkles')
            ->color('success')
            ->visible(fn (StudProj $record) => static::canStart($record))
            ->requiresConfirmation()
            ->modalHeading(__('student.title.start_project'))
            ->modalDescription($modalDescription)
            ->form([
                TextInput::make('new_name')
                    ->label(static::translation('student.table.name', 'Nazwa projektu'))
                    ->default(fn (StudProj $record) => $record->name)
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Wprowadź nazwę swojej kopii'),
            ])
            ->action(function (StudProj $record, array $data) {
                $student = Auth::user();
                abort_if(! $student, 403);

                /** @var ProjectEnrollmentService $service */
                $service = app(ProjectEnrollmentService::class);

                try {
                    $enrollment = $service->enroll($student, $record, $data['new_name']);
                } catch (ValidationException $exception) {
                    Notification::make()
                        ->title('Nie udało się rozpocząć projektu')
                        ->body(static::validationMessage($exception))
                        ->danger()
                        ->send();

                    return;
                }

                Notification::make()
                    ->title(static::translation('student.notifications.project_started_title', 'Projekt został uruchomiony'))
                    ->body(static::translation('student.notifications.project_started_body', 'Twoja kopia etapów i zadań jest gotowa do pracy.'))
                    ->actions([
                        FilamentAction::make('open_board')
                            ->label(static::translation('student.actions.open_board', 'Przejdź do tablicy'))
                            ->button()
                            ->url(UserprojResource::getUrl('view', ['record' => $enrollment]))
                            ->close(false),
                    ])
                    ->success()
                    ->send();
            });
    }

    protected static function canStart(StudProj $project): bool
    {
        $userId = Auth::id();

        if (! $userId) {
            return false;
        }

        return ! Userproj::query()
            ->where('user_id', $userId)
            ->where('project_id', $project->id)
            ->exists();
    }

    protected static function validationMessage(ValidationException $exception): string
    {
        $message = collect($exception->errors())->flatten()->first();

        return $message ?: 'Masz już aktywny zapis lub wystąpił inny problem.';
    }

    protected static function translation(string $key, string $fallback): string
    {
        $value = __($key);

        return $value === $key ? $fallback : $value;
    }
}
