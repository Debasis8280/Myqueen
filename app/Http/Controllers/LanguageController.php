<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /// change lang
    public function changeLanguage($lang)
    {
        App::setLocale($lang);
        Session::put('locale', $lang);
        return redirect(url()->previous());
    }
}