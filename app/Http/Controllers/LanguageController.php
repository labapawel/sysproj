<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // dd($locale);
        if (in_array($locale, config('app.locales'))) {
            session(['locale' => $locale]);
        }

        return \Redirect::back();
    }
}
