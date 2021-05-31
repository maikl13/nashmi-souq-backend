<?php

namespace App\Providers;

use App;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment() === 'production')
            $this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        // \Config::set('session.domain', null);
        // \Cookie::queue(\Cookie::make('version', '3.26', 5*12*30*24*60));
        // Cookie::queue(Cookie::make('version', NULL, -999999, '/', env('SESSION_DOMAIN', null)));
        // dd( $_COOKIE[ "version" ]);
        // if(request()->getHost() == config('app.domain')){
        //     $current_version = '3.28';
            
        //     $version = \Cookie::has('version') ? \Crypt::decryptString(\Cookie::get('version')) : '1.0';
        //     $version = explode('|', $version);
        //     $version = end($version);

        //     $reset = \Cookie::has('reset') ? \Crypt::decryptString(\Cookie::get('reset')) : '1.0';
        //     $reset = explode('|', $reset);
        //     $reset = end($reset);

        //     if($version != $current_version || $reset == $current_version){
        //         // $fields = ['country','country_code','nashmi_souq_session','XSRF-TOKEN','session_locale','remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', 'version'];
        //         $fields = ['country','country_code','version','reset'];

        //         if($version != $current_version) {
        //             // dd(1);
        //             foreach ($fields as $key) 
        //                 \Cookie::queue(\Cookie::forget($key), null, null);
        //             \Cookie::queue(\Cookie::make('version', $current_version, 5*12*30*24*60));
        //         } else if($reset != $current_version) {
        //             dd(2);
        //             \Config::set('session.domain', null);
        //             foreach ($fields as $key) 
        //                 \Cookie::queue(\Cookie::forget($key));
        //             \Cookie::queue(\Cookie::make('reset', $current_version, 5*12*30*24*60));
        //         }
        //         return '';
        //     }
        // }



        // Moved to a middleware
        // if(request()->getHost() == config('app.domain')){
        //     $current_version = '3.14';
        //     $version = \Cookie::has('version') ? \Crypt::decryptString(\Cookie::get('version')) : '1.0';
        //     $version = explode('|', $version);
        //     $version = end($version);
        //     if($version != $current_version){
        //         $fields = ['country','country_code','nashmi_souq_session','XSRF-TOKEN','session_locale','remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', 'version'];
        //         \Config::set('session.domain', null);
        //         foreach ($fields as $key) {
        //             \Cookie::queue(\Cookie::forget($key, null, null));
        //         }
        //         \Cookie::queue(\Cookie::make('version', $current_version, 5*12*30*24*60));
        //         return back();
        //     }
        // }

        if (App::environment() === 'production')
            $url->formatScheme('https');
    }
}
