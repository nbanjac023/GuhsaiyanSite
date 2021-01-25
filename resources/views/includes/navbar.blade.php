<header class="header">

	<div class="container">
		<nav class="navbar">
			<a href="{{ route('index') }}" class="navbar__logo-link {{ !Request::is('/') ? 'navbar__logo-link--dark' : '' }}">
				<h1 class="navbar__logo">
					GUH<span>SHOP</span>
				</h1>
			</a>

			<ul class="navbar__list">
				@if(!Request::is('/'))
					<li class="navbar__list-item"><a href="{{ route('index') }}" class="navbar__list-link {{ !Request::is('/') ? 'navbar__list-link--dark' : '' }}">Početna</a></li>
				@endif
				@auth
					
					@if(Auth::user()->isAdmin())
					<li class="navbar__list-item"><a href="{{ route('dashboard.orders.index') }}" class="navbar__list-link {{ !Request::is('/') ? 'navbar__list-link--dark' : '' }} {{ Request::is('dashboard/*') ? 'u-is-active' : '' }}">Dashboard</a></li>
					@else
					<li class="navbar__list-item"><a href="/orders" class="navbar__list-link {{ !Request::is('/') ? 'navbar__list-link--dark' : '' }} {{ Request::is('orders') ? 'u-is-active' : '' }}">Porudžbine</a></li>
					@endif
				@endauth
				
				@if(!Auth::check() || Auth::user()->isCustomer())
				<li class="navbar__list-item"><a class="navbar__list-link {{ !Request::is('/') ? 'navbar__list-link--dark' : '' }}" id="cartBtn">Korpa</a></li>
				<div class="navbar__list-cart-icon-container">
					<img src="{{ Request::is('/') ? asset('/storage/img/cart_icon.png') : asset('/storage/img/cart_icon_dark.png') }}" alt="Cart logo" id="cartBtn" class="navbar__list-cart-icon">
					<p class="navbar__list-cart-icon-status" id="cartItemCount"></p>
				</div>
				@endif
				
				
				
				
				
			</ul>


			<!-- Visible only on small sizes -->
			<a class="btn-burger {{ !Request::is('/') ? 'u-color-dark': ''}}" id="burgerBtn"></a>
		</nav>
		@if(!Request::is('cart'))
		<div class="cart"></div>
		@endif
		
		
	</div>

	
	<div class="navbar-mobile">
	
		<ul class="navbar-mobile__list">
			@if(!Request::is('/'))
				<li class="navbar-mobile__list-item"><a href="{{ route('index') }}" class="navbar-mobile__list-link">Početna</a></li>
			@endif
			@auth
					
					@if(Auth::user()->isAdmin())
					<li class="navbar-mobile__list-item"><a href="{{ route('dashboard.orders.index') }}" class="navbar__list-link {{ Request::is('dashboard/*') ? 'u-is-active' : '' }}">Dashboard</a></li>
					@else
					<li class="navbar-mobile__list-item"><a href="/orders" class="navbar__list-link {{ Request::is('orders') ? 'u-is-active' : '' }}">Porudžbine</a></li>
					@endif
				@endauth
			<li class="navbar-mobile__list-item"><a href="/cart" class="navbar__list-link">Korpa</a></li>
		</ul>
	</div>
	



</header>