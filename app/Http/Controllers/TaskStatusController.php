<?php

namespace Task_Manager\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Task_Manager\TaskStatus;
use Task_Manager\TaskStatus as Status;

class TaskStatusController extends Controller
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
        $statuses = Status::paginate(10);
        return view('statuses.index', ['statuses' => $statuses]);
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
            'name' => 'max:15|string'
        ]);
        $attributes = $request->all();
        $status = new Status();
        $status->fill([
            'name' => $attributes['name']
        ]);
        $status->saveOrFail();
        return back()->with('status', trans('state.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  TaskStatus  $status
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $status)
    {
        return view('statuses.show', ['status' => $status]);
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
    public function update(Request $request, TaskStatus $status)
    {
        $request->validate([
            'name' => 'max:15|string'
        ]);
        $attributes = $request->all();
        $status->fill([
            'name' => $attributes['name']
        ]);
        $status->save();
        return back()->with('status', trans('state.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $status)
    {
        if (TaskStatus::isSystemStatus($status['name'])) {
            return back()->withErrors(trans('state.delete_system'));
        }
        try {
            $status->delete();
        } catch (QueryException $error) {
            return back()->withErrors(trans('state.delete_failed'));
        }
        return redirect(route('statuses.index'))
            ->with('status', trans('state.delete_successful'));
    }
}
