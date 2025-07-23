<?php

namespace App\Listeners;

use App\Events\ProductsUpdated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateProductsWithDiscount
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewDiscountProducts  $event
     *
     * @return void
     */
    public function handle(ProductsUpdated $event)
    {
        Log::info('Produto com desconto no listener.... ', [$event]);
        $latestDiscount = Product::where('hasDiscount', true)->orderByDesc('updated_at')->first();

        Cache::put('discount_products', $latestDiscount, now()->addDays(10));
    }
}
