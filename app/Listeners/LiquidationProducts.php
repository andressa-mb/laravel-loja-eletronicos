<?php

namespace App\Listeners;

use App\Events\ProductsUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;;

class LiquidationProducts
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
     * @param  ProductsUpdated  $event
     * @return void
     */
    public function handle(ProductsUpdated $event)
    {
        Log::info('LISTENER = Produto com quantidade menor? ', [$event]);

        if($event->product->quantity < $event->product->getOriginal('quantity')){
            Log::info('LISTENER = Produto acabando... ', [$event]);
            Cache::put('liquidation_product', $event->product, now()->addDays(10));
        }
    }
}
