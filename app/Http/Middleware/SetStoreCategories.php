<?php

namespace App\Http\Middleware;

use Closure;

class SetStoreCategories
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
        if (auth()->check() && $request->store && auth()->user()->id == $request->store->id) {
            if (! $request->store->store_categories && ! in_array($request->route()->getName(), ['store-categories', 'store-categories.store'])) {
                return redirect()->route('store-categories');
            }
        }

        return $next($request);
    }
}
