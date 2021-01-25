<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [];

    public function pay($data)
    {
        $this->user_id = $data['user_id'];
        $this->order_id = $data['order_id'];
        $this->method = $data['method'];
        $this->paypal_status = $data['paypal_status'];
        $this->paypal_payer_email_address = $data['paypal_payer_email_address'];
        $this->paypal_payer_country_code = $data['paypal_payer_country_code'];
        $this->paypal_payment_id = $data['paypal_payment_id'];
        $this->paypal_payer_id = $data['paypal_payer_id'];
        $this->paypal_given_name = $data['paypal_given_name'];
        $this->paypal_surname = $data['paypal_surname'];
        $this->save();
    }

    public function payOnDelivery($data)
    {
        $this->user_id = $data['user_id'];
        $this->order_id = $data['order_id'];
        $this->method = $data['method'];
        $this->save();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
