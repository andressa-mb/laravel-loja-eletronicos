<?php

namespace App\Listeners;

use App\Events\NewOrderReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\User;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public $userAdmin;
    public $userAuth;
    public $newOrder;


    public function __construct(User $userAdmin, User $userAuth, NewOrderReceived $newOrder)
    {
        $this->userAdmin = $userAdmin;
        $this->userAuth = $userAuth;
        $this->newOrder = $newOrder;
        Log::info('CONTRUTOR LISTENER: SendNewOrderNotification listener initialized.');
    }

    /**
     * Handle the event.
     *
     * @param  NewOrderReceived  $event
     * @return void
     */
    public function handle(User $userAdmin, User $userAuth, NewOrderReceived $newOrder){
        Log::info('LISTENER Handling: NewOrderReceived event in SendNewOrderNotification listener.');

        // Log the received event data
        Log::info('Event Data: ', [
            'message' => $newOrder->message,
            'user_admin' => $userAdmin->id,
            'user_auth' => $userAuth->id,
        ]);

        Log::info('Listening: New order received: ', [
            'order_id' => $newOrder->order->id,
            'customer_name' => $newOrder->order->user_id,
            'order_total' => $newOrder->order->orderItems()->sum('order_total'),
        ]);

        $users = User::whereHas('roles', function ($query) {
            $query->adminRole();
        })->get();

        foreach ($users as $userAdm) {
            Log::info('AVISO PARA User Admin: ', ['user_admin' => $userAdm->id, 'new_order' => $newOrder->order->id]);
            // Here you can send the notification to each admin user
            // $user->notify(new NewOrderNotification($newOrder->order));
        }

        /*   Log::info('Listening: New order received: ', [
            'order_id' => $event->order->id,
            'customer_name' => $event->order->user_id,
            'order_total' => $event->order->orderItems()->sum('order_total'),
        ]);

        $userAdmin = User::whereHas('roles', function ($query) {
            $query->adminRole();
        })->get();

        Log::info('User Admins: ', ['user_admins' => $userAdmin]);
        if($userAdmin->count() > 0) {
            Log::info('Sending notification to user admins.');
            //$userAdmin->notify(new $event($event->order));
        } else {
            Log::warning('User does not have admin role, notification not sent.');
        } */
    }
}
