<?php


namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function changeLocale($locale)
    {
        \App::setLocale($locale);
        return redirect(route('user.update'));
    }
}
