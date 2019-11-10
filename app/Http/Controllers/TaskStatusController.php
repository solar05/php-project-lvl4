<?php

namespace Task_Manager\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Task_Manager\TaskStatus;
use Task_Manager\TaskStatus as Status;
use Illuminate\Support\Facades\Validator;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::paginate(10);
        return view('statuses', ['statuses' => $statuses]);
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
            'name' => 'max:15|string'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withErrors($errors);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $id)
    {
        return view('status', ['status' => $id]);
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
    public function update(Request $request, TaskStatus $id)
    {
        $attributes = $request->all();
        $validator = Validator::make($attributes, [
            'name' => 'max:15|string'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withErrors($errors);
        }
        $id->fill([
            'name' => $attributes['name']
        ]);
        $id->save();
        return back()->with('status', trans('state.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $id)
    {
        if (in_array($id['id'], [1, 2, 3, 4])) {
            return back()->withErrors(trans('state.delete_system'));
        }
        try {
            $id->delete();
        } catch (QueryException $error) {
            return back()->withErrors(trans('state.delete_failed'));
        }
        return redirect(route('statuses.index'))
            ->with('status', trans('state.delete_successful'));
    }
}
