<?php

namespace Task_Manager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Task_Manager\Tag;
use Task_Manager\Task;
use Task_Manager\TaskStatus;
use Task_Manager\User;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
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
        $tasks = Task::getPaginatedAndFilteredTasks();
        $users = User::has('AssignedTasks')->get();
        $tags = Tag::has('tasks')->get();
        $statuses = TaskStatus::has('tasks')->get();
        return view('tasks', [
            'tasks' => $tasks,
            'users' => $users,
            'tags' => $tags,
            'statuses' => $statuses
        ]);
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
        $attributes = $request->all();
        $validator = Validator::make($attributes, [
            'name' => 'max:255',
            'description' => 'max:255|nullable',
            'tags' => 'max:100'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withErrors($errors);
        }
        $task = new Task();
        $task->fill(['name' => $attributes['name'],
            'description' => $attributes['description']
        ]);
        if (!isset($attributes['status'])) {
            $state = TaskStatus::getCreatedState();
        } else {
            $state = TaskStatus::firstOrCreate(['name' => $attributes['status']]);
        }
        $preparedTags = Tag::prepareTags(trim($attributes['tags']));
        $task->status()->associate($state);
        $task->creator()->associate(Auth::user()['id']);
        $userToAssign = User::where('name', '=', $attributes['assignedTo'])->firstOrFail();
        $task->assignedTo()->associate($userToAssign['id']);
        $task->save();
        foreach ($preparedTags as $tag) {
            $task->tags()->attach($tag->id);
        }
        return redirect(route('tasks.index'))->with('status', trans('task.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requestedTask = Task::where('id', $id)->first();
        $creator = User::where('id', $requestedTask['creator_id'])->first();
        $performer = User::where('id', $requestedTask['assigned_to_id'])->first();
        $usersNames = User::all()->pluck('name')->toArray();
        $statuses = TaskStatus::all();
        return view('task', ['task' => $requestedTask,
            'creator' => $creator,
            'performer' => $performer,
            'tags' => $requestedTask->Tags,
            'usersNames' => $usersNames,
            'statuses' => $statuses
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
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $validator = Validator::make($attributes, [
            'name' => 'max:255',
            'description' => 'max:255|nullable',
            'tags' => 'max:100'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withErrors($errors);
        }
        $requestedTask = Task::findOrFail($id);
        $requestedTask->fill(['name' => $attributes['name'],
            'description' => $attributes['description']
        ]);
        if (isset($attributes['status'])) {
            $state = TaskStatus::firstOrCreate(['name' => $attributes['status']]);
            $requestedTask->status()->associate($state);
        }
        $userToAssign = User::where('name', '=', $attributes['assignedTo'])->firstOrFail();
        $requestedTask->assignedTo()->associate($userToAssign['id']);
        if (!empty($attributes['tags'])) {
            $preparedTags = Tag::prepareTags(trim($attributes['tags']));
            $requestedTask->tags()->detach();
            $requestedTask->save();
            foreach ($preparedTags as $tag) {
                $requestedTask->tags()->attach($tag->id);
            }
        } else {
            $requestedTask->save();
        }
        return redirect(route('tasks.show', $id))->with('status', trans('task.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requestedTask = Task::findOrFail($id);
        $requestedTask->delete();
        return redirect(route('tasks.index'))->with('status', trans('task.deleted'));
    }

    public function proceed($id)
    {
        try {
            $requestedTask = Task::findOrFail($id);
            $newState = TaskStatus::proceedToNextState($requestedTask['status_id']);
            $requestedTask->status()->associate($newState);
            $requestedTask->save();
        } catch (\Exception $error) {
            return back()->withErrors($error->getMessage());
        }
        return redirect(route('tasks.show', $id))->with('status', trans('task.proceeded'));
    }
}
