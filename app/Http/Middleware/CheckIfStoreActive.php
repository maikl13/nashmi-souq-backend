<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfStoreActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->store->is_active_store()) {
            if (auth()->user() && auth()->user()->id == $request->store->id) {
                return redirect()->route('subscribe', $request->store->store_slug);
            }

            return redirect()->route('store-unavailable', $request->store->store_slug);
            // return view('errors.unavailable-store');
        }

        return $next($request);
    }
}
