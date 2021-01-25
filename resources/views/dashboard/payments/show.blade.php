@extends('dashboard.index')
@section('title', '- Uplata - #'. $payment->id)
@section('dashboard.content')
<h1 class="dashboard__content-title">Uplata: {{ $payment->id }}</h1>

<div class="openable u-margin-bottom-sm">
            <div class="openable__closed" id="openable_closed">
                <h3 class="openable__title">Uplata: #{{ $payment->id }}</h3>
                <div class="openable__icon" id="openable__toggle"><i class="fas fa-info"></i></div>
            </div>

            <div class="openable__content openable__content--opened">
                <div class="row">
                    <div class="col-md-8">
                        <div class="openable__content-info">
                            <h3 class="openable__content-info-text">Porudžbina: <a class="openable__content-item-link" href="/dashboard/orders/{{ $payment->order->id }}"><i style="font-size: 2rem;" class="fas fa-external-link-alt"></i></a></h3>
                            <h3 class="openable__content-info-text">{{ $payment->order->user->first_name }} {{ $payment->order->user->last_name }}</h3>
                            <h3 class="openable__content-info-text">{{ $payment->method }}</h3>
                            @if($payment->method == 'Online plaćanje')
                                <h3 class="openable__content-info-text">Payment ID: {{ $payment->paypal_payment_id }}</h3>
                                <h3 class="openable__content-info-text">Status: {{ $payment->paypal_status }}</h3>
                                <h3 class="openable__content-info-text">Email adresa: {{ $payment->paypal_payer_email_address }}</h3>
                                
                            @endif
                            <h3 class="openable__content-info-text">{{ date('d m Y - H:i', strtotime($payment->created_at)) }}</h3>
                            <h3 class="openable__content-info-text"><strong>Iznos: {{ $payment->order->total + $payment->order->shipping_price }} EUR</strong></h3>
                            
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
@endsection