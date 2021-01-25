<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlaced as OrderPlacedMail;

class SendOrderPlacedNotification
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
    public function handle(OrderPlaced $event)
    {
        try {
            \Mail::to($event->order->user->email)->send(new OrderPlacedMail($event->order));
        } catch (Exception $e) {
            return redirect('/');
        }
    }
}
