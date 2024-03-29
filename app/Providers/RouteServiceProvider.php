<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Main';

    protected $store_namespace = 'App\Http\Controllers\Store';

    protected $admin_namespace = 'App\Http\Controllers\Admin';

    protected $api_namespace = 'App\Http\Controllers\Api';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('store', function ($store) {
            return \App\Models\User::where('store_slug', $store)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapStoreRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')->domain(config('app.domain'))
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapStoreRoutes()
    {
        Route::middleware('web')
            ->namespace($this->store_namespace)
            ->group(base_path('routes/store.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')->domain(config('app.domain'))
            ->prefix('admin')
            ->namespace($this->admin_namespace)
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->api_namespace)
            ->group(base_path('routes/api.php'));
    }
}
