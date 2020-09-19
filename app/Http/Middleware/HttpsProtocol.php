<?php

namespace App\Http\Middleware;

use Closure;
use App;

class HttpsProtocol
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
        // redirect to https
        if (!$request->secure())
            return redirect()->secure($request->getRequestUri());
            
        return $next($request);
    }
}
