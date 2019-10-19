<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class DeleteUserController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function delete()
    {
        $currentUser = Auth::user();
        try {
            $currentUser->delete();
        } catch (\Exception $error) {
            return redirect($this->redirectTo)->with('status', $error->getMessage());
        }
        return redirect($this->redirectTo)->with('status', 'Account succesfully deleted!');
    }

}
