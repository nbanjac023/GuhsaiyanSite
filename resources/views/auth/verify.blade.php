@extends('layouts.app')
@section('title', '- Potvrdi email adresu')
@section('content')

<section class="login u-margin-top-xxxl u-margin-bottom-xl" id="cartToggleArea">

    <div class="container">
    @if (session('resent'))
        <div class="alert alert--success" role="alert">
            {{ __('Novi link za potvrdu je poslat na vašu email adresu.') }}
        </div>
    @endif
    
        <div class="login__background col-md-12">
            <div class="login__container col-12 col-sm-11 col-md-8 col-lg-5 u-margin-top-xl u-margin-bottom-xl">
                <h1 class="login__heading login__heading-sm heading-primary-sm">Potvrdi email adresu</h1>
                <p class="login__text u-margin-top-sm">Prije nego što nastavite, molimo vas da provjerite vaš email zbog verifikacijskog linka</p>
                <p class="login__text u-margin-top-sm">Provjerite spam i promotion sandučiće</p>
                
                <form class="login__form" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <p class="login__text">Ako niste dobili email?</p>
                    <div class="login__form-btn-container u-margin-bottom-l">
                    
                        <button type="submit" class="btn btn--primary-fill">Pošaljite novi link &#8594;</button>
                    </div>
                </form>
                
            </div>

        </div>
    
    </div>

</section>

@include('includes.footer')
@endsection