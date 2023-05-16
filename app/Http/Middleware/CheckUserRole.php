<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        foreach (explode('-', $roles) as $role) {
            if ($request->user()->role() == $role) {
                return $next($request);
            }
        }

        abort(404);
    }
}
