@extends('layouts.app')
@section('title', '- Kontakt')
@section('content')
    <section class="contact u-margin-top-xxxl" id="cartToggleArea">

        <div class="container">
            <h1 class="contact__heading">Kontakt</h1>
            <div class="row">
                <div class="col-12 u-margin-top-l">
                    <h4 class="contact__sub-heading u-margin-top-l">Podaci o firmi: </h4>
                    <h4 class="contact__sub-heading-info u-margin-top-sm">GUH SAIYAN</h4>
                    <p class="contact__text">Dragoslava Djordjevica Gose 16a/03</p>
                    <p class="contact__text">Beograd, Srbija</p>
                    <p class="contact__text">Matični broj: 65618320, PIB: 111720590</p>
                    <p class="contact__text u-margin-top-m">Kontakt telefon (Poziv, SMS, Viber): </p>
                    <p class="contact__text">+381 658110019 - radnim danima 12h-20h</p>
                    <p class="contact__text u-margin-top-sm">Email adresa: </p>
                    <p class="contact__text">contact@guhsaiyan.com</p>
                    <p class="contact__text contact__text--bold u-margin-top-sm">Napomena</p>
                    <p class="contact__text">Kontakt telefon i kontakt forma su dostupani isključivo za rešavanje reklamacija, odustanaka od kupovine, zamene proizvoda, pružanje informacija o proizvodima i porudžbinama.</p>
                    <p class="contact__text">Poručivanje telefonom nije moguće, potrebno je da poružbinu napravite preko sajta.</p>
                    <p class="contact__text">Kupovina na adresi firme nije moguća.</p>
                </div>
            </div>
        </div>

    </section>
    
    @include('includes.footer')
@endsection