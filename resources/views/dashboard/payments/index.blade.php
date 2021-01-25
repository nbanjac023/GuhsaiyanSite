@extends('dashboard.index')
@section('title', '- Plaćanja')
@section('dashboard.content')
<h1 class="dashboard__content-title">Plaćanja</h1>
<form action="/dashboard/payments/search" method="POST" class="dashboard__form u-margin-top-xs u-margin-bottom-xs" role="search">
    @csrf
    <input type="number" class="dashboard__form-input" name="query" placeholder="Broj uplate" required>
    <button type="submit" class="btn btn--primary-fill dashboard__form-btn">Pretraži</button>
</form>
@if($payments->count())
    @foreach($payments as $payment)
        <div class="openable u-margin-bottom-sm">
            <div class="openable__closed" id="openable_closed">
                <h3 class="openable__title">Uplata: #{{ $payment->id }}</h3>
                <div class="openable__icon" id="openable__toggle"><i class="fas fa-info"></i></div>
            </div>

            <div class="openable__content">
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

    @endforeach
@else
    <h1>Trenutno nema uplata</h1>
@endif
{{ $payments->links() }}



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

