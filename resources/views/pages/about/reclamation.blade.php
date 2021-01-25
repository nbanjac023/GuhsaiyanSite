@extends('layouts.app')
@section('title', '- Reklamacije')
@section('content')
        <section class="about u-margin-top-xxxl" id="cartToggleArea">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="about__heading">Reklamacije</h1>
                        <ol class="about__list u-margin-top-l">
                            <p class="about__list-text">Reklamacioni list sa Pravilnikom o reklamacijama možete preuzeti <a href="/storage/pdfs/reklamacioni-list.pdf" target="_blank" rel="noopener noreferrer">Reklamacije</a></p>
                            <p class="about__list-text">Reklamacioni list sa Pravilnikom o reklamacijama možete preuzeti ovde, ili potražiti u paketu koji ste dobili.</p>
                            <h4 class="about__sub-heading u-margin-top-m">Koraci prilikom reklamacije:</h4>
                            <li class="about__list-item">Postupak Reklamacije započinje popunjavanjem zahteva za reklamaciju.</li>
                            <p class="about__list-text">Ispunite Reklamacioni list (isti se dobija prilikom isporuke robe) ili <a target="_blank" href="/storage/pdfs/reklamacioni-list.pdf">preuzmite u PDF-u.</a></p>
                            <li class="about__list-item">Sledeći korak jeste pozivanje službe Korisničke podrške na broj +381 658110019 - radno vreme je radnim danima 12-20h.</li>
                            <li class="about__list-item">Popunjen obrazac spakujte zajedno sa artiklom koji vraćate.</li> 
                            <li class="about__list-item">Artikal koji vraćate neophodno je vratiti putem kurirske službe PostExpress. Pomenutu kurirsku službu možete pozvati putem telefona na br: 011 3 607 607 radnim danima od 08:00 do 18:00h kako bi ste dogovorili preuzimanje pošiljke. Reklamirani artikal se šalje na adresu: GUH SAIYAN, Dragoslava Djordjevića Goše 16a/03, Beograd , Srbija</li>
                            <p class="about__list-text u-margin-top-m">Kada pošiljka bude dostavljena, kupac će biti obavešten. Rešenje o ishodu reklamacije kupac dobija u roku od 8 dana od dana prijema pošiljke od strane prodavca. , ili potražiti u paketu koji ste dobili.</p>
                        </ol>
                    </div>
                </div>
            </div>
        </section>


    @include('includes.footer')
@endsectioni