<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use App\Events\OrderPlaced;
use App\Listeners\SendOrderPlacedNotification;
use App\Events\OrderSent;
use App\Listeners\SendOrderSentNotificaiton;
use App\Events\ProductDeleted;
use App\Listeners\DeleteAllCartItemsThatContainProduct as DeleteCartItems;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderPlaced::class => [
            SendOrderPlacedNotification::class,
        ],
        OrderSent::class => [
            SendOrderSentNotificaiton::class,
        ],
        ProductDeleted::class => [
          DeleteCartItems::class,  
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
