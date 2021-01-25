<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public function setPlaced($order_id)
    {
        $this->order_id = $order_id;
        $this->status = 'Postavljena';
        $this->save();
    }

    public function setCall()
    {
        $this->status = 'Poziv';
        $this->update();
    }

    public function setShipped()
    {
        $this->status = 'Poslata';
        $this->update();
    }

    public function setArrived()
    {
        $this->status = 'Primljena';
        $this->update();
    }

    public function order()
    {
        $this->belongsTo(Order::class);
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->update();
    }
}
