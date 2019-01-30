<?php

namespace App\Units\Core\Http\Middleware;

use Closure;

class Json
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.force_json')) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
