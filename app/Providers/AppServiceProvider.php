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

        if(request()->path() != 'clear-cookies'){
            $current_version = env('APP_VERSION');

            $version = \Cookie::has('version') ? \Crypt::decryptString(\Cookie::get('version')) : '1.0';
            $version = explode('|', $version);
            $version = end($version);

            $fields = ['country','country_code','version'];

            // dd($version);

            if($version != $current_version){
                \Config::set('session.domain', null);
                foreach ($fields as $key) 
                    \Cookie::queue(\Cookie::forget($key)); 
            }
        }

        if (App::environment() === 'production')
            $url->formatScheme('https');
    }
}
