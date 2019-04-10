<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the change password page.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('account.password');
    }

    /**
     * Update a users password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->getAuthPassword())) {
            return back()->with('error', 'Current password is not correct, please try again');
        }

        $request->validate([
            'new_password' => 'required|confirmed'
        ]);

        $password_updated = User::changePassword($request->new_password);

        return $password_updated ? back()->with('success', 'New password has been updated') : back()->with('error', 'Unable to update password, please try again');
    }
}
