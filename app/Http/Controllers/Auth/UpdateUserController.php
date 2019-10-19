<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

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
            return redirect(route('user.show'))->with('errors', implode('', $errors));
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
            return redirect(route('user.show'))
                ->with('errors', 'An account is already registered on the entered email!');
        }
        return redirect(route('user.show'))->with('status', 'Account succesfully updated!');
    }
}
