<?php


namespace Task_Manager\Http\Controllers;

class LocaleController extends Controller
{
    public function changeLocale($locale)
    {
        \App::setLocale($locale);
        return redirect(route('users.update'));
    }
}
