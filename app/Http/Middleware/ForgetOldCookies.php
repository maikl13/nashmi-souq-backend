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
        // session()->put('clear-cookies', true);

        // \Config::set('session.domain', null);
        // Cookie::queue(Cookie::make('version', NULL, -999999, '/', env('SESSION_DOMAIN', null)));
        // if(request()->getHost() == config('app.domain')){
        //     $current_version = '3.25';
        //     $version = \Cookie::get('version');
        //     // dd(session()->get('cookies-reset-1'), session()->get('cookies-reset-2'));
        //     // dd((session()->get('cookies-reset-1') != $current_version || session()->get('cookies-reset-2') != $current_version));
        //     if($version != $current_version && 
        //         (session()->get('cookies-reset-1') != $current_version || session()->get('cookies-reset-2') != $current_version)
        //     ){
        //         // dd('here');
        //         // $fields = ['country','country_code','nashmi_souq_session','XSRF-TOKEN','session_locale','remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', 'version'];
        //         $fields = ['country','country_code','version'];

        //         if(session()->get('cookies-reset-1') != $current_version) {
        //             dd(1);
        //             \Config::set('session.domain', null);
        //             foreach ($fields as $key) 
        //                 \Cookie::queue(\Cookie::forget($key), null, null);
        //         } else {
        //             dd(2);
        //             // \Config::set('session.domain', env('SESSION_DOMAIN', null));
        //             foreach ($fields as $key) 
        //                 \Cookie::queue(\Cookie::forget($key));
        //             session()->put('cookies-reset-2', $current_version);
        //             \Cookie::queue(\Cookie::make('version', $current_version, 5*12*30*24*60));
        //         }
        //         return redirect()->route('home');
        //     }
        // }

        return $next($request);
    }
}
