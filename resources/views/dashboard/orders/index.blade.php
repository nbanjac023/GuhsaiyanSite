@extends('dashboard.index')
@section('title', '- Porudžbine')
@section('dashboard.content')
<h1 class="dashboard__content-title">Porudžbine</h1>
<form action="/dashboard/orders/search" method="POST" class="dashboard__form u-margin-top-xs u-margin-bottom-xs" role="search">
    @csrf
    <input type="number" class="dashboard__form-input" name="query" placeholder="Broj porudžbine" required>
    <button type="submit" class="btn btn--primary-fill dashboard__form-btn">Pretraži</button>
</form>
@if($orders->count())
    @foreach($orders as $order)
        <div class="openable u-margin-bottom-sm @if($order->isArrived()) openable--success @else openable--false @endif @if($order->isInvalid()) openable--invalid @else '' @endif">
            <div class="openable__closed" id="openable_closed">
                <h3 class="openable__title">Porudžbina: #{{ $order->id }} @if($order->isInvalid()) - NEVALIDNA @endif</h3>
                <div class="openable__icon" id="openable__toggle"><i class="fas fa-info"></i></div>
            </div>

            <div class="openable__content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="openable__content-info">
                            
                            <h3 class="openable__content-info-text">{{ $order->user->first_name }} {{ $order->user->last_name }}</h3>
                            @if($order->hasAddress())
                            <h3 class="openable__content-info-text">{{ $order->address->street_name }} {{ $order->address->apt_number }}, {{ $order->address->city }}, {{ $order->address->postal_code }}</h3>
                            <h3 class="openable__content-info-text">{{ $order->address->country }}</h3>
                            @endif
                            <h3 class="openable__content-info-text">{{ $order->user->phone_number }}</h3>
                            <h3 class="openable__content-info-text">Poruceno: {{ date('d m Y - H:m', strtotime($order->created_at)) }}</h3>
                            <h3 class="openable__content-info-text">Dostava: {{ $order->shipping_price }} EUR</h3>
                            <h3 class="openable__content-info-text">Total:  {{ $order->total }} EUR</h3>
                            @if(isset($order->payment))
                                <h3 class="openable__content-info-text">Uplata: <a class="openable__content-item-link" href="/dashboard/payments/{{ $order->payment->id }}"><i style="font-size: 2rem;" class="fas fa-external-link-alt"></i></a></h3>
                                @if($order->payment->method == "Online plaćanje")
                                    <h3 class="openable__content-info-text">Plaćeno:  {{ $order->total + $order->shipping_price }} EUR</h3> 
                                @else
                                    <h3 class="openable__content-info-text">Za platiti: {{ $order->total + $order->shipping_price }} EUR</h3>
                                @endif
                                
                                <div class="openable__content-payment-wrap">
                                    <p class="openable__content-payment-text">{{ $order->payment->method }}</p>
                                    <p class="openable__content-payment-text">{{ date('d m Y - H:i', strtotime($order->payment->created_at)) }}</p>
                                </div>
                            
                            
                            
                            <form action="/dashboard/orders/{{ $order->id }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="openable__form-group">
                                    <select name="status" id="status" class="openable__form-select">
                                        <option value="Postavljena" @if($order->isPlaced()) selected @endif disabled>Postavljena</option>
                                        <option value="Poziv" @if($order->isCall()) selected @endif>Poziv</option>
                                        <option value="Poslata" @if($order->isShipped()) selected @endif>Poslata</option>
                                        <option value="Primljena" @if($order->isArrived()) selected @endif>Primljena</option>
                                    </select>
                                </div>
                                <button type="submit" class="openable__btn u-margin-top-sm">Postavi status</button>

                            </form>
                            @endif
                        </div>                    
                    </div>
                    <div class="col-md-8">
                        <div class="openable__content-items">
                        @foreach($order->orderitems as $item)
                            <div class="openable__content-item">    
                                    <div class="openable__content-item-wrap">
                                        <div class="openable__content-item-text-wrapper">
                                            <h3 class="openable__content-item-text">{{ $item->product->name }}</h3>
                                            <h3 class="openable__content-item-text">Veličina: {{ $item->size }}</h3>
                                            <h3 class="openable__content-item-text">Kolicina: {{ $item->quantity }}</h3>
                                            <h3 class="openable__content-item-text">{{ $item->quantity * $order->getPriceInRSD($item->product) }} RSD - {{ $item->quantity * $item->product->price }} EUR</h3>
                                        </div>
                                        <div class="openable__content-item-img-wrapper">
                                            <img src="/storage/{{ $item->product->category->name }}/{{ $item->product->images[0]->image_name }}" alt="{{ $item->product->name }}" class="openable__content-item-img">
                                        </div>
                                    </div>
                                    <a href="/product/{{ $item->product->id }}" class="openable__content-item-link" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                            </div>
                        @endforeach
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

    @endforeach
    {{ $orders->links() }}
@else
    <h1>Trenutno nema postavljenih porudžbi</h1>
@endif




<script>
    
        const openableClosed = document.querySelectorAll('#openable_closed');
        openableClosed.forEach(element => {
            element.addEventListener('click', (event) => {
                toggleOpenable(event.target);
            });
        });

        function toggleOpenable(element){
            let openable = element.parentElement.children[1];
            /*
            #FIXME
            @desc:
                For some reason it selects an icon element
            */
            if(openable.classList.contains('openable__icon')) return;
            if(openable){
                openable.classList.toggle('openable__content--opened');
            }
            
        }
    
    

</script>

@endsection

