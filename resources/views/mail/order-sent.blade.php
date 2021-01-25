@component('mail::message')
Poštovani,<br>
Vaša porudžbina je poslata na adresu:
{{ $order->address->street_name }} {{ $order->address->apt_number }}, {{ $order->address->city }}, {{ $order->address->postal_code }}, {{ $order->address->country }}.



@component('mail::button', ['url' => 'https://guhsaiyan.com/orders'])
Pogledajte vaše porudžbine
@endcomponent

Hvala<br>
{{ config('app.name') }}
@endcomponent
