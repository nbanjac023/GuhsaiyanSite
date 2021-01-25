@extends('layouts.app')
@section('title', '- Porudžbina - ' . $order->id)


@section('content')

    <section class="orders u-margin-top-xxxl" id="cartToggleArea">
        <div class="container">
            <div class="row">
                <div class="orders__container u-center-flex u-flex-direction-column col-md-12 col-lg-10 mx-auto">
                    @if($completed || session('success'))
                    <div class="orders__success-svg-container">
                        <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70">
                            <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#005596" stroke-width="2" stroke-linecap="round" fill="transparent"/>
                            <polyline id="successAnimationCheck" stroke="#005596" stroke-width="2" points="23 34 34 43 47 27" fill="transparent"/>
                        </svg>
                    </div>
                    <h1 class="orders__success-heading">Uspešno naručeno</h1>
                    <h3 class="orders__success-subheading">Vaša porudžbina je uspešno kreirana!, broj porudžbine: {{ $order->id }}</h3>
                    <p class="orders__success-text">U nastavku možete da pogledate detalje. E-mail potvrdu ćete dobiti u narednih 10 minuta.</p>
                    @else
                        <h1 class="orders__success-heading u-margin-top-m">Detalji porudžbine</h1>
                        <h3 class="orders__success-subheading">Broj porudžbine: {{ $order->id }}</h3>
                    @endif
                    
                    <div class="row u-margin-top-m">
                        <div class="col-md-6 mt-sm-5">
                            <h3 class="orders__shipping-info-heading">Podaci za dostavu</h3>
                            <div class="orders__shipping-group">
                                <label for="name" class="orders__shipping-group-label">Ime i prezime</label>
                                <input type="text" id="name" class="orders__shipping-group-input" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" disabled>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="orders__shipping-group">
                                        <label for="telefon" class="orders__shipping-group-label">Kontakt telefon</label>
                                        <input type="text" id="telefon" class="orders__shipping-group-input" value="{{ auth()->user()->phone_number }}" disabled>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="orders__shipping-group">
                                        <label for="email" class="orders__shipping-group-label">E-mail adresa</label>
                                        <input type="text" id="email" class="orders__shipping-group-input" value="{{ auth()->user()->email }}" disabled>
                                    </div> 
                                </div>
                            </div>
                            <div class="orders__shipping-group">
                                <label for="adresa" class="orders__shipping-group-label">Adresa</label>
                                <input type="text" id="adresa" class="orders__shipping-group-input" value="{{ $order->address->street_name }}" disabled>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="orders__shipping-group">
                                        <label for="city" class="orders__shipping-group-label">Grad</label>
                                        <input type="text" id="city" class="orders__shipping-group-input" value="{{ $order->address->city }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="orders__shipping-group">
                                        <label for="postal_code" class="orders__shipping-group-label">Poštanski broj</label>
                                        <input type="text" id="postal_code" class="orders__shipping-group-input" value="{{ $order->address->postal_code }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="orders__shipping-group">
                                        <label for="country" class="orders__shipping-group-label">Država</label>
                                        <input type="text" id="country" class="orders__shipping-group-input" value="{{ $order->address->country }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <hr class="u-margin-top-m">
                            <div class="row">
                                @if(session('success'))
                                <div class="col-12 col-sm-12 col-md-6 u-center-flex">
                                    <h3 class="orders__success-subheading-2 u-margin-top-sm">❤️ Hvala Vam na porudžbini</h3>
                                </div>
                                @endif
                                <div class="col-12 col-sm-12 col-md-6 u-center-flex">
                                    <a href="/orders" class="btn btn--primary-fill u-margin-top-sm orders__success-btn">&larr; Nazad</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-sm-5">
                            <h3 class="orders__shipping-info-heading">Vaša porudžbina</h3>
                            <div class="col-md-12 u-margin-top-xs">
                                @foreach($order->orderitems as $item)
                                    <div class="cart-item">
                                        <div class="cart-item__img-container">
                                            <img src="/storage/{{ $item->product->category->name }}/{{ $item->product->images[0]->image_name }}" alt="{{ $item->product->name }}" class="cart-item__img">
                                        </div>
                                        <div class="cart-item__content">
                                            <h1 class="cart-item__heading">{{ $item->product->name }}</h1>
                                            <h1 class="heading-small">{{ $order->getProductPriceConverted($item->product, $item->quantity) }} {{ $order->getOrderCurrency()  }}</h1>
                                            <p>Količina: {{ $item->quantity }}</p>
                                            <p>Veličina: {{ $item->size }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <div class="orders__shipping-group">
                                    <label for="payment" class="orders__shipping-group-label">Način plaćanja</label>
                                    <input type="text" id="payment" class="orders__shipping-group-input" value="{{ $order->payment->method }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="orders__shipping-group">
                                    <label for="shipping" class="orders__shipping-group-label">Dostava</label>
                                    <input type="text" id="shipping" class="orders__shipping-group-input" value="{{ $order->getOrderShipping() }} {{ $order->getOrderCurrency() }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="orders__shipping-group">
                                    <label for="total" class="orders__shipping-group-label">Ukupno sa cenom dostave</label>
                                    <input type="text" id="total" class="orders__shipping-group-input" value="{{ $order->getTotalWithShipping() }} {{ $order->getOrderCurrency() }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 u-margin-top-m u-margin-bottom-m">
                            <div class="orders__status">
                                @if($order->isPlaced())
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-cart"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon ">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-phone"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-truck"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-home3"></use>
                                    </svg>
                                </div>

                                @elseif($order->isCall())

                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-cart"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-phone"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-truck"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-home3"></use>
                                    </svg>
                                </div>

                                @elseif($order->isShipped())
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-cart"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-phone"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-truck"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box">
                                    <svg class="orders__status-icon">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-home3"></use>
                                    </svg>
                                </div>

                                @elseif($order->isArrived())
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-cart"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-phone"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-truck"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                <div class="orders__status-icon-box orders__status-icon-box--active">
                                    <svg class="orders__status-icon orders__status-icon--active">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-home3"></use>
                                    </svg>
                                    <svg  class="orders__status-icon-checkmark">
                                        <use xlink:href="/storage/img/order_icons.svg#icon-checkmark"></use>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('includes.footer')
@endsection