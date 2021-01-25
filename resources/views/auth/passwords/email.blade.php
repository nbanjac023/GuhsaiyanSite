@extends('layouts.app')
@section('title', '- Nova lozinka')
@section('content')

<section class="login u-margin-top-xxxl u-margin-bottom-xl" id="cartToggleArea">

    <div class="container">
    @if (session('status'))
        <div class="alert alert--success">
            <div class="alert__message">{{ session('status') }}</div>
        </div>    
    @endif
    
        <div class="login__background col-md-12">
            <div class="login__container col-12 col-sm-11 col-md-8 col-lg-5 u-margin-top-xl u-margin-bottom-xl">
                <h1 class="login__heading login__heading-sm heading-primary-m">Nova lozinka</h1>

                <form method="POST" action="{{ route('password.email') }}" class="login__form">
                    @csrf
                    <div class="login__form-group">
                        <label for="email" class="login__form-label">Email adresa</label>
                        <input type="text" class="login__form-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="login__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="login__form-btn-container u-margin-bottom-l">
                    
                        <button type="submit" class="btn btn--primary-fill">Pošaljite link za oporavak loznike &#8594;</button>
                    </div>
                    <div class="login__register-container">
                    <a href="{{ route('login') }}" class="login__register-anchor">Prijava</a>
                </div>
                </form>
            </div>

        </div>
    
    </div>

</section>

@include('includes.footer')
@endsection