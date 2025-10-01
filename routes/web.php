<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/panel');
});

Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
