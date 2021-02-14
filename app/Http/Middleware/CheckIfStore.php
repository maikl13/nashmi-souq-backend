<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfStore
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
        if(!auth()->user()->is_store()){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
