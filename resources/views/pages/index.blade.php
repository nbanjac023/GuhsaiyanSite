@extends('layouts.app')


@section('title', '- Shop')
@section('content')

	<section class="section-intro" id="cartToggleArea">
		
		@include('includes.alert')
		<div class="content-container">
			<div class="section-intro-scroll u-margin-top-m">
				<a href="#categories" class="btn btn--primary-fill section-intro__btn">&darr; Poruči odmah &darr;</a>
			</div>
		</div>
		


	</section>
	{{--  
	<section class="section-latest-products" id="sectionProducts">
		<div class="container">
		
			<div class="row">
			
				<div class="latest-product col-md-10 mx-auto">
					<div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="latest-product__img-wrapper">
								<img src="/storage/{{ $productAd->product->category->name }}/{{ $productAd->product->images[0]->image_name }}" class="latest-product__img" alt="{{ $productAd->product->name }}">
							</div>
						</div>
						<div class="col-md-12 col-lg-6">
						
							<div class="latest-product__info">
								<h1 class="latest-product__ad">{{ $productAd->heading }}</h1>		
								<hr>
								<h4 class="latest-product__name u-margin-top-m">{{ $productAd->product->name }}</h4>
								<hr>
								<h4 class="latest-product__price">{{ $productAd->product->price_rsd  }} {{ $currency }}</h4>
								@guest
								<h4 class="latest-product__price latest-product__price--small">{{ $productAd->product->price  }} {{ $currencyEur }}</h4>
								@endguest
								
								<a href="/product/{{ $productAd->product->id }}" class="btn btn--primary-fill latest-product__btn u-margin-top-l u-margin-bottom-l">Poruči</a>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		
	</section>
	--}}

	<section class="product_ad">
		<div class="container product_ad__container">
			<h1 class="product_ad__heading">KOMPLET TRENERKA <br>  NA POPUSTU OD 1. MARTA DO 20. MARTA</h1>

			<div class="row">
						@foreach($products_on_sale as $product_on_sale)
							<div class="col-sm-12 col-md-6 col-lg-6 product-wrapper mx-auto">
								<div class="product-index">
									<a class="product-index__link" href="/product/{{ $product_on_sale->product->id }}">
										@if(count($product_on_sale->product->images) > 0)
											@foreach($product_on_sale->product->images as $image)
												<div class="slide @if($loop->index == 0) slide--active @endif">
													<img src="/storage/{{ $product_on_sale->product->category->name }}/{{ $image->image_name }}" data-id="{{ $product_on_sale->product->id }}" id="productImage" alt="{{ $product_on_sale->product->name }}" class="product-index__image">
												</div>
											@endforeach
										@endif
									</a>
									<div class="product-index__image-buttons">

										@if(count($product_on_sale->product->images) > 1)
											<!-- @foreach($product_on_sale->product->images as $image)
												@if($loop->index < 2)
												<a id="toggle" class="toggle" data-name="/storage/{{ $product_on_sale->product->category->name }}/{{ $image->image_name }}"><i class="fas fa-circle"></i></a>
												@endif
											@endforeach -->
											<a id="toggleLeft" class="toggle">&#10094;</a>
											<a id="toggleRight" class="toggle">&#10095;</a>
										@endif
									</div>
									@auth
										@if(auth()->user()->isFromSerbia())
											<div class="old-price">{{ $product_on_sale->old_price_rsd }} RSD</div>
											<div class="new-price">{{ $product_on_sale->product->price_rsd }} RSD</div>
										@elseif(!auth()->user()->isFromSerbia())
											<div class="old-price">{{ $product_on_sale->old_price }} EUR</div>
											<div class="new-price">{{ $product_on_sale->product->price }} EUR</div>
										@endif
									@endauth

									@guest
									<div class="old-price">{{ $product_on_sale->old_price_rsd }} RSD - {{ $product_on_sale->old_price }} EUR</div>
									<div class="new-price">{{ $product_on_sale->product->price_rsd }} RSD - {{ $product_on_sale->product->price }} EUR</div>                   
									@endguest
									
								</div>
							</div>
						@endforeach
					</div>
		</div>
	</section>

	<section class="categories" id="categories">
		<div class="container">
			<div class="row">
				@foreach($categories as $category)
				
				<div class="col-lg-12 category">
					<h1 class="category__name">{{ $category->name }}</h1>
					<hr>
					<div class="row mt-5">
						@foreach($category->products as $product)
							<div class="col-sm-12 col-md-6 col-lg-6 product-wrapper mx-auto">
								<div class="product-index m-3">
									<a class="product-index__link" href="/product/{{ $product->id }}">
										@if(count($product->images) > 0)
											@foreach($product->images as $image)
												<div class="slide @if($loop->index == 0) slide--active @endif">
													<img src="/storage/{{ $category->name }}/{{ $image->image_name }}" data-id="{{ $product->id }}" id="productImage" alt="{{ $product->name }}" class="product-index__image">
												</div>
											@endforeach
										@endif
									</a>
									<div class="product-index__image-buttons">

										@if(count($product->images) > 1)
											<!-- @foreach($product->images as $image)
												@if($loop->index < 2)
												<a id="toggle" class="toggle" data-name="/storage/{{ $category->name }}/{{ $image->image_name }}"><i class="fas fa-circle"></i></a>
												@endif
											@endforeach -->
											<a id="toggleLeft" class="toggle">&#10094;</a>
											<a id="toggleRight" class="toggle">&#10095;</a>
										@endif
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				@endforeach 
					
					
			</div>
		</div>
	</section>
	@include('includes.footer')


	<script>



		class ImageSlider {
			constructor(imgs, togglerLeft, toggleRight){
				this.togglerLeft = togglerLeft;
				this.togglerRight = toggleRight;
				this.imgs = imgs;
				this.currentImage = null;
				this.clear();
				this.currentIndex = 0;
				this.previousIndex = null;
				this.showImage(this.currentIndex);
				this.addListeners();
				
			}
			addListeners() {
				
				if(this.togglerLeft){
					this.togglerLeft.addEventListener('click', () => {
						this.toggleLeft();
					});
				}
				if(this.togglerRight){
					this.togglerRight.addEventListener('click', () => {
						this.toggleRight();
					});
				}
				
			}

			clear() {
				for(let img of this.imgs){
					// Check if type of node is text, it it is, remove it because we don't need it, we need just the div
					if(img.nodeType == 3){
						img.remove();
					}
				}
			}

			showImage(index) {
				
				this.imgs[index].classList.add('slide--active');
				this.currentImage = this.imgs[index];
				this.currentIndex = index;
				
			
				
			}
			hideImage(previous){
				this.imgs[previous].classList.remove('slide--active');
			}

			toggleRight(){
				if(this.currentIndex + 1 < this.imgs.length){
					this.previousIndex = this.currentIndex;
					this.currentIndex += 1;
					this.showImage(this.currentIndex);
					
				}
				this.hideImage(this.previousIndex);
				
				
			}
			toggleLeft(){
				if(this.currentIndex - 1 >= 0){
					this.previousIndex = this.currentIndex;
					this.currentIndex -= 1;
					this.showImage(this.currentIndex);
					this.hideImage(this.previousIndex);
				}

				
			}

			
		}

		let imageInstances = [];

		// Instantiate imgs
		let allProducts = document.querySelectorAll('.product-index__link');
		for(let product of allProducts){
			
			let leftToggler = product.nextElementSibling.children[0];
			let rightToggler = product.nextElementSibling.children[1];
			let productChilds = product.childNodes;
			for(let child of productChilds){
				if(child.nodeType == 1){
					imageInstances.push(new ImageSlider(productChilds, leftToggler, rightToggler));
					break;
				}
			}
		}
		
				
				
				
	
	</script>

@endsection