<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use App;

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
        if(request()->getHost() == config('app.url')){
            $current_version = '3.03';
            $version = \Cookie::has('version') ? \Crypt::decryptString(\Cookie::get('version')) : '1.0';
            $version = explode('|', $version);
            $version = end($version);
            if($version != $current_version){
                if(request()->path() != '/') {
                    return redirect('/')->send();
                } else {
                    \Config::set('session.domain', null);
                    foreach (['country','country_code','nashmi_souq_session','XSRF-TOKEN','session_locale','remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'] as $key)
                        \Cookie::queue(\Cookie::forget($key));
                    \Cookie::queue(\Cookie::make('version', $current_version, 5*12*30*24*60));
                }
            }
        }

        if (App::environment() === 'production')
            $url->formatScheme('https');
    }
}
