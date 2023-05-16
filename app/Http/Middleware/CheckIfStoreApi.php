<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfStoreApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->user()->is_store()) {
            abort(403);
        }

        return $next($request);
    }
}
