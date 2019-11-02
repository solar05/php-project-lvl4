<?php

namespace Task_Manager\Http\Controllers\Auth;

use Task_Manager\Http\Controllers\Controller;
use Task_Manager\Task;
use Task_Manager\User;

class ShowUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $completedTasksCount = Task::getCompletedUserTasksCount($user['id']);
        return view('account')->with([
            'userName' => $user->name,
            'userEmail' => $user->email,
            'completedTasksCount' => $completedTasksCount
        ]);
    }
}
