<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\OrderPlaced;
use App\Events\OrderSent;
use App\Http\Controllers\CurrencyController;

class Order extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => OrderPlaced::class,
        'updated' => OrderSent::class
    ];

    public function createOrder($user_id, $total, $shipping_price)
    {
        // $shipping_price = auth()->user()->isFromSerbia() ? ''
        $this->user_id = $user_id;
        $this->total = $total;
        $this->shipping_price = $shipping_price;
        $this->save();
    }

    public function assignItemsToOrder($items = [])
    {
        foreach ($items as $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $this->id;
            $orderItem->product_id = $item->product_id;
            $orderItem->size = $item->size;
            $orderItem->quantity = $item->quantity;
            $orderItem->save();
            $item->delete();
        }
    }

    /*
    getProductPriceConverted
    @desc:
        Konvertuje cijenu proizvoda izrazenu u eurima u dinare
    @params:
        $producPrice - cijena proizvoda,
    @return: double - cijena u dinarima ako je korisnik iz srbije, else vrati u eurima
    */

    public function getProductPriceConverted($product, $quantity)
    {
        if ($this->address->country == 'Srbija') {
            return $product->price_rsd * $quantity;
        } else {
            return $product->price * $quantity;
        }
    }

    /*
    getPriceInRSD
    @desc:
        Ako proslijedimo prvi parametar, vratit ce njegovu cijenu zaokruzenu na drugu decimalu
        Ako proslijedimo prvi parametar null, a drugi kao cijenu, vratit ce tu cijenu u dinarima,
        Ako proslijedimo prva dva parametra null a treci kao cijenu dostave, vratit ce ukupnu cijenu porudzbe sa uracunatom cijenom dostave
        Else ce vratiti ukupnu cijenu porudzbe bez uracunate cijene dostave
    @params:
        $product - App\Product - Objekat proizvoda,
        $price - double - Cijena proizvoda
        $shipping - bool - Ukupna cijena porudzbe sa postarinom
    @return:  double -  cijena u dinarima
    */

    public function getPriceInRSD($product = null, $price = null, $shipping = null)
    {
        if ($product) {
            return $product->price_rsd;
        } elseif ($price) {
            return round(CurrencyController::getInRSD($price), 2);
        } elseif ($shipping) {
            return round(CurrrencyController::getInRSD($this->total + $this->shipping_price), 2);
        } else {
            return round(CurrencyController::getInRSD($this->total), 2);
        }
    }

    /*
    getShippingPriceConverted
    @desc:
        Konvertuje cijenu dostave ako je korisnik iz srbije, else vraca u eurima
    @params:
        $shippingPrice - cijena dostave,
    @return: double - cijena
    */

    public function getShippingPriceConverted()
    {
        if (CurrencyController::isSerbia()) {
            return 240;
        } else {
            return $this->shipping_price;
        }
    }

    public function getOrderCurrency()
    {
        if ($this->address->country == 'Srbija') {
            return 'RSD';
        } else {
            return 'EUR';
        }
    }

    public function getTotalWithShipping()
    {
        if ($this->address->country == 'Srbija') {
            $total = 0;
            foreach ($this->orderitems as $item) {
                $total += $item->product->price_rsd * $item->quantity;
            }
            return $total + 240;
        } else {
            $total = 0;
            foreach ($this->orderitems as $item) {
                $total += $item->product->price * $item->quantity;
            }
            return $total + 8.5;
        }
    }

    public function getOrderShipping()
    {
        if ($this->address->country == 'Srbija') {
            return 240;
        } else {
            return 8.5;
        }
    }

    /*
    getShippingPriceForAdmin
    @desc:
        vraca cijenu shipping-a preracunatu u dinare, zaokruzenu na prirodan broj ako je adresa dostave srbija, else vraca 1000din
        odradjeno je ovako jer je klijent u zadnji trenutak trazio da mu se cijene ne racunaju preko UpdateRates job-a
    @return: int cijena - cijena postarine
    */
    public function getShippingPriceForAdmin()
    {
        // return 1000;
        if ($this->address->country == 'Srbija') {
            return 240;
        } else {
            return 1000;
        }
    }

    /*
    getOrderTotal
    @desc:
        Vraca ukupnu cijenu porudzbe sa uracunatom cijenom dostave i ako je potrebno konvertuje u dinare
    @return: double - ukupna cijena porudzbe
    */

    public function getOrderTotal()
    {
        if (CurrencyController::isSerbia()) {
            return round(CurrencyController::getInRSD($this->total + $this->shipping_price), 2);
        } else {
            return $this->total;
        }
    }

    public function getOrderTotalWithoutShipping()
    {
        return round(CurrencyController::getInRSD($this->total), 1);
    }

    public function getStatus()
    {
        return $this->status->status;
    }

    public function isPlaced()
    {
        $this->setStatusAsPlaced();
        return $this->status->status == 'Postavljena' ? true : false;
    }

    public function isCall()
    {
        $this->setStatusAsPlaced();
        return $this->status->status == 'Poziv' ? true : false;
    }

    public function isShipped()
    {
        $this->setStatusAsPlaced();
        return $this->status->status == 'Poslata' ? true : false;
    }

    public function isArrived()
    {
        $this->setStatusAsPlaced();
        return $this->status->status == 'Primljena' ? true : false;
    }

    public function ship()
    {
        event(new OrderSent($this));
        $this->update();
    }

    public function setStatus($status)
    {
        $this->status->setStatus($status);
    }

    public function isInvalid()
    {
        if (!isset($this->payment)) {
            return true;
        } else {
            return false;
        }
    }

    public function hasAddress()
    {
        if (isset($this->address)) {
            return true;
        } else {
            return false;
        }
    }

    protected static function boot()
    {
        parent::boot();
    }

    public function setStatusAsPlaced()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            if ($order->status == null) {
                $status = new OrderStatus();
                $status->setPlaced($order->id);
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
