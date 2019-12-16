<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function showForgotform()
    {
        return view('cms.auth.password-email');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('cms.index'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'You have provided invalid credentials, please try again.');
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect(route('cms.index'));

    }
}
