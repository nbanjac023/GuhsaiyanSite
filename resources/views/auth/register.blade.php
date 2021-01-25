@extends('layouts.app')
@section('title', '- Registracija')
@section('content')

<section class="register u-margin-top-xxxl u-margin-bottom-xl" id="cartToggleArea">

    <div class="container">
    
        <div class="register__background col-md-12">

            <div class="register__container col-12 col-sm-11 col-md-8 col-lg-5 u-margin-top-xl u-margin-bottom-xl">
                <h1 class="register__heading login__heading-sm heading-primary-m">Registracija</h1>

                <form action="{{ route('register') }}" class="register__form" method="POST">
                    @csrf
                    <div class="register__form-group">
                        <label for="first_name" class="register__form-label">Ime</label>
                        <input type="text" class="register__form-input" name="first_name" id="first_name" required autocomplete="name">
                        @error('first_name')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="register__form-group">
                        <label for="last_name" class="register__form-label">Prezime</label>
                        <input type="text" class="register__form-input" name="last_name" id="last_name" required autocomplete="name">
                        @error('last_name')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="register__form-group">
                        <label for="email" class="register__form-label">Email adresa</label>
                        <input type="text" class="register__form-input" name="email" id="email" required autocomplete="email">
                        @error('email')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="register__form-group">
                        <label for="password" class="register__form-label">Lozinka</label>
                        <input type="password" class="register__form-input" name="password" id="password" required autocomplete="new-password">
                        @error('password')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="register__form-group">
                        <label for="email" class="register__form-label">Potvrdite lozinku</label>
                        <input type="password" class="register__form-input" name="password_confirmation" id="password-confirm" required autocomplete="new-password">
                        @error('password_confirmation')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="register__form-btn-container">
                    
                        <button type="submit" class="btn btn--red-fill">Registrujte se &#8594;</button>
                    </div>
                
                </form>
                
                <div class="login__register-container">
                    <a href="/login" class="register__register-anchor">Imate nalog? Prijavite se</a>
                </div>
            
            </div>

        </div>
    
    </div>

</section>

@include('includes.footer')
@endsection