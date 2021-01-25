<?php

namespace App\Listeners;

use App\Events\OrderSent;
use App\Mail\OrderSent as OrderSentMail;

class SendOrderSentNotificaiton
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
     * @param  object  $event
     * @return void
     */
    public function handle(OrderSent $event)
    {
        try {
            if ($event->order->isShipped()) {
                \Mail::to($event->order->user->email)->send(new OrderSentMail($event->order));
            }
        } catch (Exception $e) {
            return redirect('/');
        }
    }
}
