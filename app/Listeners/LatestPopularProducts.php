<?php

namespace App\Listeners;

use App\Events\ProductsUpdated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LatestPopularProducts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PopularProducts  $event
     * @return void
     */
    public function handle(ProductsUpdated $event)
    {
        Log::info('LISTENER = Produto alterado a quantidade... ', [$event]);
        Cache::put('popular_product', $event->product, now()->addDays(10));
    }

}
