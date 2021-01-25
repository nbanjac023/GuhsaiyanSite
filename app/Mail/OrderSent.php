<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSent extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no_reply@guhsaiyan.com')->subject('STATUS: Porudžbina poslata')->markdown('mail.order-sent');
    }
}
