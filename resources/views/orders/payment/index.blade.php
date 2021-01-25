@extends('layouts.app')

@section('title', '- Plaćanje')
@section('content')


<section class="payment u-margin-top-xxxl" id="cartToggleArea">
    <div class="container">
        <div class="row">
            <div class="payment__wrapper col-md-6 col-lg-4">
                <h1 class="payment__heading">Način plaćanja</h1>
                <h3 class="payment__disclaimer payment__disclaimer--hidden u-text-center u-margin-top-xs u-margin-bottom-xs"></h3>
                @if(!auth()->user()->isFromSerbia())
                <div class="payment__paypal" id="paypal-button-container">
                    <script
                        src="https://www.paypal.com/sdk/js?client-id={{ $clientID }}&currency=EUR">
                    </script>
                </div>
                @endif
                @if(auth()->user()->isFromBalkan())
                <div class="payment__cod">
                    <form action="/orders/payment/cod" method="POST">
                        @csrf
                        <input type="hidden" name="cod" value="cod">
                        <button class="payment__cod-btn" type="submit" onclick="submitForm(this)">Plaćanje po pouzeću</button>
                    </form>
                </div>
                @endif
            </div>

        </div>


    </div>

</section>





@include('includes.footer')


<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
@if(!auth()->user()->isFromSerbia())
<script>
    let data = null;
    
    let total = axios
    .get("/api/orders/orderitems")
    .then(response => {
        data = response.data;
        total = data.total + data.shipping_price;
        return total;
    })
    .catch(e => {
        
    });

    function submitForm(btn){
        // disable the button
        btn.disabled = true;
        // submit the form    
        btn.form.submit();
    }
    
    
    function sendOrderData(data){
        axios.post('/orders', data)
            .then(response => {
                window.location.href = '/orders';
            }).catch( err => { 
                console.log(err);
            });
    }
    function check(total, totalCheck) {
        return total == totalCheck ? true : false;
    }

    function showDisclaimer(text){
        let disclaimer = document.querySelector('.payment__disclaimer');
        disclaimer.innerHTML = text;
        disclaimer.classList.remove('payment__disclaimer--hidden');
    }
    
    paypal.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [
                {
                    description: 'GuhSaiyan SHOP',
                    amount: {
                        currency_code: 'EUR',
                        value: total
                    }
                }
            ]
            });
        },
        onClick: (data, actions) => {
            return fetch("/api/orders/orderitems")
            .then(function(response) {
                return response.json();
            }).then(function(data){
                let totalCheck = data.total + data.shipping_price;
                if(!check(total, totalCheck)){
                    showDisclaimer("Can't do that buddy");
                    return actions.reject();
                } else {
                    showDisclaimer("Nakon što platite sačekajte da vas sistem automatski  preusmjeri");
                    return actions.resolve();
                }
            }); 
        },
        onApprove: async (data, actions) => {
            const order = await actions.order.capture().then(function(details){
                return fetch('/orders', {
                    method: 'post',
                    credentials: "same-origin",
                    headers: {
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    }),
                    redirect: 'follow'
                }).then(function(response) {
                    let id = axios.get('/api/orders/status').then(response => { 
                        // console.log(response.data);
                        window.location.href = `/orders/${response.data}?completed=true`; 
                        }
                    );
                    
                });
                // axios.post('/orders', {orderID:data.orderID});
            });
        },
        
        onError: err => {
            console.log("Error: " + err);
        }
    }).render('#paypal-button-container');
</script>
@endif
@endsection