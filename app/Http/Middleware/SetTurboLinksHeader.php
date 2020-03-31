<?php

namespace App\Http\Middleware;

use Closure;

class SetTurboLinksHeader
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
        $response = $next($request);

        if ($response->getContent() === '') {
            $response->header('Turbolinks-Location', $request->url());
        }

        return $response;
    }
}
