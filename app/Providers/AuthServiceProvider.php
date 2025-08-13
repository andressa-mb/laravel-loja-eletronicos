<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        'App\Models\OrderProductItem' => 'App\Policies\Reports\ReportPolicy',
        'App\Models\Order' => 'App\Policies\Orders\OrderPolicy',
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
