<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Transaction' => 'App\Policies\TransactionPolicy',
        'App\Models\Listing' => 'App\Policies\ListingPolicy',
        'App\Models\Order' => 'App\Policies\OrderPolicy',
        'App\Models\Package' => 'App\Policies\PackagePolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
