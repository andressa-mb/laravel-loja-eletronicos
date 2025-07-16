<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $wish;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product, $wish)
    {
        $this->product = $product;
        $this->wish = $wish;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'O produto ' . $this->product->name . 'foi atualizado.',
            'product' => $this->product->id,
            'wish' => $this->wish->id
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'O produto '.$this->product->name.' foi atualizado!',
            'product_id' => $this->product->id,
            'wish_id' => $this->wish->id,
            'url' => route('view-product', $this->product),
            'changes' => [
                'price' => $this->product->price,
                'quantity' => $this->product->quantity,
                'hasDiscount' => $this->product->hasDiscount

            ]
        ];
    }
}
