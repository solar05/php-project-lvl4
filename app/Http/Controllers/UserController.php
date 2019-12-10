<?php

namespace Task_Manager\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Task_Manager\Task;
use Task_Manager\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $completedTasksCount = Task::getCompletedUserTasksCount($user['id']);
        return view('user.show', [
            'user' => $user,
            'completedTasksCount' => $completedTasksCount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'max:255|nullable',
            'email' => 'email|nullable'
        ]);
        $data = $request->all();
        if (!empty($data['name'])) {
            $user->name = $data['name'];
        }
        if (!empty($data['email'])) {
            $user->email = $data['email'];
        }
        try {
            $user->update();
        } catch (QueryException $error) {
            return back()
                ->withErrors([trans('account.failure_update')]);
        }
        return redirect(route('users.show', $user))->with('status', trans('account.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('welcome'))->with('status', trans('account.success_delete'));
    }
}
