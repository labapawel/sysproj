<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');