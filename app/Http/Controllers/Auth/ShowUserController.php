<?php

namespace Task_Manager\Http\Controllers\Auth;

use Task_Manager\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShowUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $currentUser = Auth::user();
        return view('account')->with([
            'userName' => $currentUser->name,
            'userEmail' => $currentUser->email
        ]);
    }
}
