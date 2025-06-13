<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewOrderReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * @return void
     */

    public $message;
    public $order;
    public $userId;

    public function __construct(Order $order, int $userId, $message = "Novo pedido recebido (CONSTRUCTOR)")
    {
        $this->message = $message;
        $this->order = $order;
        $this->userId = $userId;
        Log::info('EVENTO: NewOrderReceived event created with order ID: ' . $order->id . ' and userID: ' . $userId . ' ' . $message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return [
            new Channel('admins'),
        ];
    }

    public function broadcastAs()
    {
        return 'new_order';
    }
}
