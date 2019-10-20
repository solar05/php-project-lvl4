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
            return back()->withErrors([trans('account.failure_delete')]);
        }
        return redirect($this->redirectTo)->with('status', trans('account.success_delete'));
    }
}
