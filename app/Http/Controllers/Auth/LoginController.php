<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Checked that the logged in user has a customer allocated (And exists), if
     * not, log the user out displaying the message.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, User $user)
    {
        if (!$user->customer) {
            Session::remove('temp_customer');
            Auth::logout();

            return back()->with('errors', ['no_customer' => 'This account does not have a customer assigned, please contact the sales office reporting this error.']);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * @return bool|string
     */
    public function loginContent()
    {
        $external_url = curl_init('https://scolmore.com/newproducts.php');

        curl_setopt($external_url, CURLOPT_RETURNTRANSFER, 1);
        $external_content = curl_exec($external_url);

        return $external_content;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([
            $field => $request->input($this->username()),
        ]);

        return $request->only($field, 'password');
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
