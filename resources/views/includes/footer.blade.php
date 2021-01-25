<footer class="footer u-margin-top-xxl">

	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="footer__logo-container">
					<h1 class="footer__logo">
						GUH<span>SHOP</span>
					</h1>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="footer__social_icons">
							<a href="https://www.youtube.com/channel/UCo4wYJ-F0EobT6_VodyRWLQ" class="footer__social-links">
								<img src="{{ asset('/storage/img/youtube.png') }}" alt="Youtube" class="footer__social_icons-img">
							</a>
							<a href="https://www.twitch.tv/guhsaiyan" class="footer__social-links">
								<img src="{{ asset('/storage/img/twitch.png') }}" alt="Twitch" class="footer__social_icons-img">
							</a>
							<a href="https://www.instagram.com/guhsajan/" class="footer__social-links">
								<img src="{{ asset('/storage/img/instagram.png') }}" alt="Instagram" class="footer__social_icons-img">
							</a>
							
						</div>
					</div>
				</div>
			</div>
			<div class="footer__rows col-sm-10 col-md-12 col-lg-6">
				<div class="row">
					<div class="footer__col col- col-sm-10 col-md-6 col-lg-6">
						<h1 class="footer__heading">- Opšte informacije</h1>
						<ul class="footer__list">
							<li class="footer__list-item"><a class="footer__list-link" href="/about/shipping">Dostava</a></li>
							<li class="footer__list-item"><a class="footer__list-link" href="/about/terms">Uslovi kupovine</a></li>
							<li class="footer__list-item"><a class="footer__list-link" href="/about/sizes">Veličine proizvoda</a></li>
						</ul>
					</div>
					<div class="footer__col col- col-sm-10 col-md-6 col-lg-6">
						<h1 class="footer__heading">- Pomoć i informacije</h1>
						<ul class="footer__list">
							@if(!Auth::check() || Auth::user()->role->role == 'customer')
							<li class="footer__list-item"><a class="footer__list-link" href="/about/contact">Kontakt</a></li>
							@endif
							<li class="footer__list-item"><a class="footer__list-link" href="/about/reclamation">Reklamacije</a></li>
							<li class="footer__list-item"><a class="footer__list-link" href="/about/cancel">Odustanak od kupovine</a></li>
							@auth
							<li class="footer__list-item"><a class="footer__list-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Odjava</a></li>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
							</form>

							@else
							<li class="footer__list-item"><a class="footer__list-link" href="/login">Prijava</a></li>
							@endauth
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer__payment-cards-wrapper row u-margin-top-xl">
			<div class="col-lg-12">
				<div class="footer__payment-cards">
					<img src="{{ asset('/storage/img/mastercard.png') }}" alt="Mastercard" class="footer__payment-cards__img">
					<img src="{{ asset('/storage/img/visa.png') }}" alt="Mastercard" class="footer__payment-cards__img">
					<img src="{{ asset('/storage/img/paypal.png') }}" alt="Mastercard" class="footer__payment-cards__img">
				</div>
			</div>
		</div>
	</div>

	<div class="footer__copyright u-margin-top-l">
		<p>Copyright © GuhSaiyanShop - 2019		|		All rights reserved. &mdash; Web Development by <a href="https://omaririskic.com/" class="footer__copyright-link" target="_blank">omaririskic.com</a> & <a href="https://www.instagram.com/banjac_n/" target="_blank" class="footer__copyright-link">Nikola Banjac</a></p>
	</div>

</footer>