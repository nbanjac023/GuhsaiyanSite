@component('mail::message')
Poštovani,<br>
Vaša porudžbina je uspjesno postavljena.


@component('mail::button', ['url' => 'https://guhsaiyan.com/orders'])
Pogledajte vaše porudžbine
@endcomponent

Hvala,<br>
{{ config('app.name') }}
@endcomponent
