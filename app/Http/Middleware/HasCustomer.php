<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->customer) {
            Auth::logout();

            return redirect(route('login'))->with('errors', ['no_customer' => 'This account does not have a customer assigned, please contact the sales office reporting this error.']);
        }

        return $next($request);
    }
}
