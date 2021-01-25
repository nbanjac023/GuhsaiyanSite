<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [];

    /*
    add
    @desc:
        Creates new address, if orderId is passed it will create an order address so address will be binded to order instead of the user
    @params:
        $data - data to be passed,
        $orderid - id of the order, if not passed, an address for the user will be created
    @return: void -
    */

    public function add($data, $orderId = null)
    {
        if ($orderId) {
            $this->order_id = $orderId;
            $this->street_name = $data['street_name'];
            $this->apt_number = $data['apt_number'];
            $this->city = $data['city'];
            $this->postal_code = $data['postal_code'];
            $this->country = $data['country'];
            $this->save();
        } else {
            $this->user_id = $data['user_id'];
            $this->street_name = $data['street_name'];
            $this->apt_number = $data['apt_number'];
            $this->city = $data['city'];
            $this->postal_code = $data['postal_code'];
            $this->country = $data['country'];
            $this->save();
        }
    }

    public function edit($data)
    {
        $this->user_id = $data['user_id'];
        $this->street_name = $data['street_name'];
        $this->apt_number = $data['apt_number'];
        $this->city = $data['city'];
        $this->postal_code = $data['postal_code'];
        $this->country = $data['country'];
        $this->update();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
