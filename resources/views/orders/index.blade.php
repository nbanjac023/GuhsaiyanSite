@extends('layouts.app')
@section('title', '- Moje porudžbine')


@section('content')


    <section class="orders u-margin-top-xxxl" id="cartToggleArea">
    
        <div class="container">
            @include('includes.alert')
                
            <div class="row">
                
                <div class="orders__container col-12 col-md-12">
                        <div class="row">
                        <div class="col-md-12 mt-5 ml-5"><h1 class="u-text-uppercase">Prethodne porudžbine</h1></div>
                            <div class="col-md-12 mx-auto">
                            @if(auth()->user()->orders)
                            
                            <div class="orders__placed u-margin-top-sm">
                                <div class="row">
                                    @foreach(auth()->user()->orders as $order)
                                    
                                    <div class="col-md-10 mx-auto mb-3 orders__item-container">
                                        <a href="/orders/{{ $order->id }}" class="orders__link">
                                            <div class="orders__item">
                                                <h3 class="orders__item-heading">Porudžbina - #{{ $order->id }}</h3>
                                                <p class="orders__item-info">Pogledajte detalje</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            @endif
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="shipping-wrapper">
                                    <div class="shipping-info u-margin-top-m u-margin-bottom-m">
                                        <div class="shipping-info__wrapper">
                                            <div class="shipping-info__group">
                                                <p class="shipping-info__group-label">Kontakt</p>
                                                <p class="shipping-info__group-data">{{ auth()->user()->email }} - {{ auth()->user()->phone_number }}</p>
                                            </div>
                                            <hr>
                                            <div class="shipping-info__group">
                                                <p class="shipping-info__group-label">Adresa</p>
                                                <p class="shipping-info__group-data">{{ auth()->user()->address->street_name }}, {{ auth()->user()->address->apt_number }}, {{ auth()->user()->address->city }}, {{ auth()->user()->address->postal_code }}, {{ auth()->user()->address->country }}</p>
                                            </div>
                                            <hr>
                                            <div class="shipping-info__group">
                                                <p class="shipping-info__group-label">Dostava</p>
                                                <p class="shipping-info__group-data">{{ $shipping_price }} {{ $currency }}</p>
                                            </div>
                                            <hr>
                                            <div class="shipping-info__group">
                                                <p class="shipping-info__group-label">Total</p>
                                                <p class="shipping-info__group-data">{{ $total }} {{ $currency }}</p>
                                            </div>
                                            <hr>
                                            <div class="shipping-info__group">
                                                <p class="shipping-info__group-label">Za platiti</p>
                                                <p class="shipping-info__group-data">{{ $total + $shipping_price }} {{ $currency }}</p>
                                            </div>
                                            <hr>
                                            <div class="shipping-info__btn-container">
                                                <a href="{{ route('address.edit', auth()->user()->address) }}" class="btn btn--primary mr-lg-4">Izmeni adresu</a>
                                                <a href="/orders/payment" class="btn btn--primary-fill">Poruči</a>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6 col-lg-6 u-margin-top-sm u-margin-bottom-sm" id="orderShowItems">
                            </div>  
                        </div>       
                </div>
            </div>
        </div>

    </section>

    @include('includes.footer')


@endsection