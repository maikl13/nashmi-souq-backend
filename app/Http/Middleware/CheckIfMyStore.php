<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfMyStore
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
        if (! auth()->check() || ! auth()->user()->is_store() || ! isset($request->store) || auth()->user()->id != optional($request->store)->id) {
            return redirect()->route('store-home', $request->store->store_slug);
        }

        return $next($request);
    }
}
