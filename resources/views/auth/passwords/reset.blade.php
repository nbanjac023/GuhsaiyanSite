@extends('layouts.app')
@section('title', '- Reset lozinke')
@section('content')

<section class="login u-margin-top-xxxl u-margin-bottom-xl" id="cartToggleArea">

    <div class="container">
    
        <div class="login__background col-md-12">

        
        
            <div class="login__container col-12 col-sm-11 col-md-8 col-lg-5 u-margin-top-xl u-margin-bottom-xl">
                <h1 class="login__heading login__heading-sm heading-primary-m">Nova lozinka</h1>

                <form method="POST" action="{{ route('password.update') }}" class="login__form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="login__form-group">
                        <label for="email" class="login__form-label">Email adresa</label>
                        <input type="text" id="email" class="login__form-input" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-group">
                        <label for="password" class="login__form-label">Lozinka</label>
                        <input type="password" id="password" class="login__form-input" name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-group">
                        <label for="password-confirm" class="login__form-label">Potvrdi lozinku</label>
                        <input type="password" id="password-confirm" class="login__form-input" name="password_confirmation" required autocomplete="new-password">
                        @error('password')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-btn-container u-margin-bottom-l">
                    
                        <button type="submit" class="btn btn--primary-fill">Resetuj lozinku &#8594;</button>
                    </div>
                </form>
            </div>

        </div>
    
    </div>

</section>

@include('includes.footer')
@endsection