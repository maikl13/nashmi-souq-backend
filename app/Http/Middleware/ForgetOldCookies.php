<?php

namespace App\Http\Middleware;

use Closure;

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
        if ($version = \Cookie::get('version') && request()->path() != 'clear-cookies') {
            $current_version = env('APP_VERSION');

            if ($version != $current_version) {
                return redirect()->to('/clear-cookies');
            }
        }

        return $next($request);
    }
}
