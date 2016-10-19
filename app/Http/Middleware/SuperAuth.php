<?php

namespace App\Http\Middleware;

use Closure;

class SuperAuth
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
        if(! $request->user()->isA('super_admin')) {
            return abort(403);
        }
        return $next($request);
    }
}
