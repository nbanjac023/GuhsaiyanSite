@extends('layouts.app')

@section('title', '- ' . $product->name )

@section('content')

<section class="section-product u-margin-top-xxxl" id="cartToggleArea">

    <div class="container">
        <div class="row">
            <div class="alert alert--hidden col-md-12" id="alert">
                <h1 id="alert-text">Proizvod je dodat u korpu</h1>
            </div>
            <div class="col-sm-12 col-md-7">

                <div class="product u-move-in-right">
                    <div class="product__card">
                        <img id="productImg" class="product__image" src="/storage/{{ $product->category->name }}/{{ $product->images[0]->image_name }}" alt="{{ $product->name }}" >
                    </div>
                    
                        @if(count($product->images) > 1)
                        <div class="product__images">
                            @foreach($product->images as $image)
                                @continue($loop->index == 0)
                                @if($loop->index < 5)
                                    <div class="product__small-wrapper">
                                        <img data-id="{{ $product->id }}" id="productSmallImg"  class="product__small" src="/storage/{{ $product->category->name }}/{{ $image->image_name }}" alt="{{ $product->name }}">
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        @endif
                    

                </div>

            </div>
            <div class="col-sm-12 col-md-5">
                <div class="product-info u-move-in-left">
                    @if($product->available)
                    <h1 class="product-info__heading">{{ $product->name }}</h1>
                    @auth
                        @if(auth()->user()->isFromSerbia())
                        <h2 class="product-info__price">{{ $product->price_rsd  }} {{ $currency }}</h2> 
                        @elseif(!auth()->user()->isFromSerbia())
                            <h2 class="product-info__price">{{ $product->price }} {{ $currencyEur }}</h2>
                        @else
                        <h2 class="product-info__price">{{ $product->price_rsd }} {{ $currency }} - {{ $product->price }} {{ $currencyEur }}</h2>                    
                        @endif
                    @endauth
                    @guest
                    <h2 class="product-info__price">{{ $product->price_rsd }} {{ $currency }} - {{ $product->price }} {{ $currencyEur }}</h2>                    
                    @endguest
                    <p class="product-info__price--small">+  cena dostave</p>
                    <div class="product-info__size-howto">
                        <a id="sizeModalBtn" class="product-info__size-link">Sastav proizvoda i informacije</a>
                    </div>
                    @if($product->show_size == true)
                        @if(isset($product->sizes[0]->height) && isset($product->sizes[0]->width))
                        <div class="product-info__table-container">
                            <table class="product-info__table">
                                <tr>
                                    <th></th>
                                    @foreach($product->sizes as $size)
                                    <th>{{ explode(" ",$size->size)[0] }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @if($product->category->name == 'bokserice')
                                        <th>Obim struka</th>
                                    @else
                                        <th>Dužina</th>
                                    @endif
                                    @foreach($product->sizes as $size)
                                    <td>{{ $size->height }}</td>
                                    @endforeach
                                    
                                </tr>
                                <tr>
                                    @if($product->category->name == 'bokserice')
                                        <th>Obim bokova</th>
                                    @else
                                        <th>Širina</th>
                                    @endif
                                    @foreach($product->sizes as $size)
                                        <td>{{ $size->width }}</td>
                                    @endforeach     
                                </tr>
                            </table>
                        </div>
                        @endif
                    @endif
                    
                    <select name="size" id="size" class="product-info__select">
                        <option value="none" selected disabled>VELIČINA</option>
                        @foreach($product->sizes as $size)
                            <option value="{{ $size->size }}" @if(stristr($size->size, 'Rasprodato')) disabled @endif >{{ $size->size }}</option>
                        @endforeach
                    </select>
                    
                    <div class="product-info__form-group">
                        <p class="product-info__form-label">Količina</p>
                        <input class="product-info__form-input" type="number" name="quantity" min="1" max="5" id="quantity" value="1">
                    </div>
                    @if(!Auth::check() || Auth::user()->role->role == 'customer')
                        <a data-id="{{ $product->id }}" id="addToCartBtn" class="btn btn--primary product-info__btn">Dodaj u korpu</a>
                    @endif
                @else
                    <div class="product-info__not-available">
                        <h1 class="product-info__not-available-emoji">😔</h1>
                        <h1 class="product-info__not-available-heading">Oh ne!</h1>
                        <p>Zakasnio si. <br> Ovaj proizvod trenutno nije u ponudi. <br>Nove količine uskoro stižu!</p>
                        <p class="u-margin-top-m">Zaprati @guhsajan na Instagramu i prvi <br>saznaj za nove proizvode.</p>
                    </div>
                @endif
                </div>
            </div>
        </div>

    </div>

</section>

<div class="modal" id="sizeModal">
    <div class="modal__content">
        <div class="modal__header">
            <h3 class="modal__header-text">Sirovinski sastav proizvoda i informacije</h3>
            <span class="modal__close">&times;</span>
        </div>
        
        <div class="modal__content-info">
            <img src="{{ asset('/storage/img/logo-lg.png') }}" alt="Guh Saiyan Logo" class="modal__logo">
            <div class="modal__content-info-text">
                <p class="modal__text">
                <span class="modal__text-name">{{ $product->name }}</span> <br>
                {{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')

<script>
    if(document.getElementById('sizeModal') && document.getElementById('sizeModalBtn')){
        let modal = document.getElementById('sizeModal');
        let modalToggleBtn = document.getElementById('sizeModalBtn').addEventListener('click', () => {
            modal.style.display = 'block';
        });
        let spanEl = document.getElementsByClassName('modal__close')[0].addEventListener('click', () => {
            modal.style.display = 'none';
        });
        window.addEventListener('click', (e) => {
            if (e.target == 'modal') {
                modal.style.display = 'none';
            }
        });
    }
    

</script>
@endsection