<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentUser = Auth::user();
        return view('account')->with([
            'userName' => $currentUser->name,
            'userEmail' => $currentUser->email
        ]);
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
            return redirect(route('account'))->with('errors', implode('', $errors));
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
            return redirect(route('account'))->with('errors', 'An account is already registered on the entered email!');
        }
        return redirect(route('account'))->with('status', 'Account succesfully updated!');
    }
}
