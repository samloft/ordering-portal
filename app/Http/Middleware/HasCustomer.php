<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Session;

class HasCustomer
{
    /**
     * Handle an incoming request.
     *
     * Checks that the current logged in user has a customer account allocated to it and that the customer exists.
     * If not, the user will be logged out and an error message displayed.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->customer) {
            Session::remove('temp_customer');
            Auth::logout();

            return redirect(route('login'))->with('errors', ['no_customer' => 'This account does not have a customer assigned, please contact the sales office reporting this error.']);
        }

        return $next($request);
    }
}
