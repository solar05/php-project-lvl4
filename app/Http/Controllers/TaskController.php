<?php

namespace Task_Manager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Task_Manager\Tag;
use Task_Manager\Task;
use Task_Manager\TaskStatus;
use Task_Manager\User;

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
        return view('tasks.index', [
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
        $request->validate([
            'name' => 'max:255',
            'description' => 'max:255|nullable',
            'tags' => 'max:100'
        ]);
        $attributes = $request->all();
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
    public function show(Task $task)
    {
        $creator = User::findOrFail($task['creator_id']);
        $performer = User::findOrFail($task['assigned_to_id']);
        $usersNames = User::all()->pluck('name')->toArray();
        $statuses = TaskStatus::all();
        return view('tasks.show', ['task' => $task,
            'creator' => $creator,
            'performer' => $performer,
            'tags' => $task->Tags,
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
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'max:255',
            'description' => 'max:255|nullable',
            'tags' => 'max:100'
        ]);
        $attributes = $request->all();
        $task->fill(['name' => $attributes['name'],
            'description' => $attributes['description']
        ]);
        if (isset($attributes['status'])) {
            $state = TaskStatus::firstOrCreate(['name' => $attributes['status']]);
            $task->status()->associate($state);
        }
        $userToAssign = User::where('name', '=', $attributes['assignedTo'])->firstOrFail();
        $task->assignedTo()->associate($userToAssign['id']);
        if (!empty($attributes['tags'])) {
            $preparedTags = Tag::prepareTags(trim($attributes['tags']));
            $task->tags()->detach();
            $task->save();
            foreach ($preparedTags as $tag) {
                $task->tags()->attach($tag->id);
            }
        } else {
            $task->save();
        }
        return redirect(route('tasks.show', $task))->with('status', trans('task.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
        } catch (\Exception $e) {
            return back()->withErrors(trans('task.delete_err'));
        }
        return redirect(route('tasks.index'))->with('status', trans('task.deleted'));
    }
}
