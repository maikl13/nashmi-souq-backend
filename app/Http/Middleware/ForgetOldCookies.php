<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class ForgetOldCookies
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
        if(request()->path() != 'clear-cookies'){
            $current_version = env('APP_VERSION');
            $version = \Cookie::get('version', '1.0');

            if($version != $current_version)
                return redirect()->to('/clear-cookies');
        }

        return $next($request);
    }
}
