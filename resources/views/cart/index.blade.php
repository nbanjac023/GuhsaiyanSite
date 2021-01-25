@extends('layouts.app')
@section('title', '- Korpa')
@section('content')

<section class="cart-section u-margin-top-xxxl" id="cartToggleArea">
    <div class="container">
        <h1 class="heading-primary-m u-margin-bottom-m u-center-flex">Korpa</h1>
        <div class="cart cart--active cart--block u-margin-auto"></div>
    </div>

</section>
    @include('includes.footer')
@endsection