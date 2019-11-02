<?php

namespace Task_Manager\Http\Controllers\Auth;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Task_Manager\Http\Controllers\Controller;

class UpdateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $currentUser = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'max:255|nullable',
            'email' => 'email|nullable'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withErrors($errors);
        }
        $data = $validator->getData();
        if (!empty($data['name'])) {
            $currentUser->name = $data['name'];
        }
        if (!empty($data['email'])) {
            $currentUser->email = $data['email'];
        }
        try {
            $currentUser->update();
        } catch (QueryException $error) {
            return back()
                ->withErrors([trans('account.failure_update')]);
        }
        return redirect(route('users.show', $currentUser['id']))->with('status', trans('account.success_update'));
    }
}
