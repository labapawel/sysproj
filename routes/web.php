<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    return redirect('/panel');
});


Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');