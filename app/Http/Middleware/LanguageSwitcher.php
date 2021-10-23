<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('locale')) {
            $lang = Admin::first();
            if (!$lang->lang)
                Session::put('locale', Config::get('app.locale'));
            else
                Session::put('locale', $lang->lang);
        }
        App::setLocale(session('locale'));
        return $next($request);
    }
}