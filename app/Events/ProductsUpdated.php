<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProductsUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $isNewProduct;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Product $product, bool $isNewProduct)
    {
        $this->product = $product;
        $this->isNewProduct = $isNewProduct;
        Log::alert('Produto com desconto: ' . $product . ' produto novo: ' . $isNewProduct);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
