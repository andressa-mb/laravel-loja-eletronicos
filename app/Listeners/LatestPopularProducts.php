<?php

namespace App\Listeners;

use App\Events\ProductsUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
