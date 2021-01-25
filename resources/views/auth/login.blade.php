@extends('layouts.app')
@section('title', '- Prijava')
@section('content')

<section class="login u-margin-top-xxxl u-margin-bottom-xl" id="cartToggleArea">

    <div class="container">
    
        <div class="login__background col-md-12">

        
        
            <div class="login__container col-12 col-sm-11 col-md-8 col-lg-5 u-margin-top-xl u-margin-bottom-xl">
                <h1 class="login__heading login__heading-sm heading-primary-m">PRIJAVA</h1>

                <form action="{{ route('login') }}" class="login__form" method="POST">
                    @csrf
                    <div class="login__form-group">
                        <label for="email" class="login__form-label">Email adresa</label>
                        <input type="text" class="login__form-input" name="email">
                        @error('email')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-group">
                        <label for="email" class="login__form-label">Lozinka</label>
                        <input type="password" class="login__form-input" name="password">
                        @error('password')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-btn-container">
                    
                        <button type="submit" class="btn btn--primary-fill">Prijavite se &#8594;</button>
                    </div>
                
                </form>
                @if(Route::has('password.request'))
                <div class="login__register-container">
                    <a href="{{ route('password.request') }}" class="login__register-anchor">Zaboravili ste lozinku?</a>
                </div>
                @endif
                <div class="login__register-container">
                    <a href="/register" class="login__register-anchor">Nemate nalog? Registrujte se</a>
                </div>
            
            </div>

        </div>
    
    </div>

</section>

@include('includes.footer')
@endsection