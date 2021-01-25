@extends('layouts.app')
@section('title', '- Veličine proizvoda')
@section('content')
        <section class="about u-margin-top-xxxl" id="cartToggleArea">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="about__heading">Veličine proizvoda</h1>
                        <div class="about__list u-margin-top-l">
                            <p class="about__list-text">Na stranici proizvoda nalazi se tabela sa veličinama.</p>
                            <p class="about__list-text">Sve veličine izražene su u cm, osim ukoliko nije drugačije navedeno. Savetujemo da pre poručivanja izmerite neki proizvod koji već imate i na taj način odlučite koja veličina vam je potrebna.</p>
                            <p class="about__list-text">Ukoliko veličina poručenog proizvoda ne odgovara, možete je zameniti. Zahtev za promenu veličine možete pronaći u paketu zajedno sa robom, ili ga možete preuzeti <a href="/storage/pdfs/zahtev-velicina.pdf" target="_blank" rel="noopener noreferrer">ovde</a></p>
                            <p class="about__list-text">Troškove vraćanja robe (troškovi dostave) snosi isključivo potrošač, izuzev u slučajevima kada potrošač od trgovca dobije neispravan ili pogrešan proizvod.</p>
                            <p class="about__list-text">U slučaju da željene veličine nema na stanju, potrošaču će biti ponuđena zamena za drugi proizvod ili će dobiti povrat novca.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    @include('includes.footer')
@endsection