<?php
//
//namespace App\Http\Middleware;
//
//use Closure;
//use Auth;
//
//class CmsAdmin
//{
//    /**
//     * Checks if the logged in user has access to the CMS
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//        if (auth()->user() && auth()->user()->cms_admin === 1) {
//            return $next($request);
//        }
//
//        return redirect('/login');
//    }
//}
