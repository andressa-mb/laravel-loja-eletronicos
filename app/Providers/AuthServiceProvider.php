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
        'App\Models\Product' => 'App\Policies\Products\ProductPolicy',
        'App\Models\Category' => 'App\Policies\Categories\CategoryPolicy',
        'App\User' => 'App\Policies\User\UserPolicy',
        'App\Models\Discount' => 'App\Policies\Discounts\DiscountPolicy',
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
