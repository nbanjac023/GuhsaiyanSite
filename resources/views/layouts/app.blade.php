<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- SEO -->
    <meta name="description" content="Zvanična prodavnica najjače porodice na YouTube-u #GuhSaiyan!">
    <meta name="robots" content="index, follow" />

    <meta name="geo.position" content="44.7866° N, 20.4489° E">
    <meta name="geo.placename" content="Belgrade, Serbia">
    <meta name="keywords" content="Ivan Ilić, GuhSaiyan, GuhSaiyanShop, Webshop, GuhShop, guhshop, guhsaiyanshop, guhsaiyan, ivan ilic, jutjub, jutub shop, youtube shop">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-155078850-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-155078850-1');
    </script>


    <!-- Favicons -->

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">


    <title>GuhSaiyan @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
</head>
<body class="{{ Request::is('/') ? 'u-snap' : '' }}">
    @include('includes.navbar')
    @yield('content')


    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
    <script>
        window.cookieconsent.initialise({
        "palette": {
            "popup": {
            "background": "#11111b",
            "text": "#e0a330"
            },
            "button": {
            "background": "#e0a330",
            "text": "#11111b"
            }
        },
        "theme": "classic",
        "content": {
            "message": "Ovaj sajt koristi kolačiće. Zakon navodi da možemo čuvati kolačiće na vašem uređaju ako su strogo neophodni za rad ovog sajta. Za sve ostale tipove kolačića nam je potrebna vaša saglasnost.",
            "dismiss": "Prihvati kolačiće",
            "link": "Saznaj više",
            "href": "/about/cookies"
        }
        });
    </script>
</body>
</html>
