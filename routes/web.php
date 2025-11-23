<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Student\EnrollmentBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/panel');
});

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware(['auth'])->prefix('student')->as('student.')->group(function () {
    Route::post('enrollments/{enrollment}/stages/{stage}/sync', [EnrollmentBoardController::class, 'sync'])
        ->name('enrollments.stages.sync');
});
