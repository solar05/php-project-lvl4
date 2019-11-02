<?php

namespace Task_Manager\Http\Controllers;

use Task_Manager\Task;
use Illuminate\Support\Facades\Auth;
use Task_Manager\TaskStatus;
use Task_Manager\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $usersNames = User::all()->pluck('name')->toArray();
        $userTasks = Task::where('assigned_to_id', $user['id'])
            ->whereNotIn('status_id', [4])
            ->get();
        return view('home', ['userTasks' => $userTasks,
            'usersNames' => $usersNames]);
    }

    public function account()
    {
        return view('account');
    }
}
