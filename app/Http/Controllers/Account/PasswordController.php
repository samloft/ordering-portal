<?php

namespace App\Http\Controllers\Account;

use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->getAuthPassword())) {
            return back()->with('error', 'Current password is not correct, please try again');
        }

        if ($request->new_password <> $request->confirm_new_password) {
            return back()->with('error', 'New password and confirm must match');
        }

        $password_updated = User::changePassword($request->new_password);

        return $password_updated ? back()->with('success', 'New password has been updated') : back()->with('error', 'Unable to update password, please try again');
    }
}
