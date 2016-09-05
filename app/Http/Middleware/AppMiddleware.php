<?php

namespace App\Http\Middleware;

use Closure;

class AppMiddleware
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
        config([
            'key' => env('RZP_KEY', null),
            'secret' => env('RZP_SECRET', null)
        ]);

        return $next($request);
    }
}
