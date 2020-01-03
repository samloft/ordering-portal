<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Show the reset email form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('authentication.passwords.email');
    }

    /**
     * password broker for admin guard.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker('cms_users');
    }

    /**
     * Get the guard to be used during authentication
     * after password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(): StatefulGuard
    {
        return Auth::guard('admin');
    }
}
