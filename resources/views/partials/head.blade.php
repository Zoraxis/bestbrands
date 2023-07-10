<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>BestBrands</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="{{asset('css/futura.css')}}" rel="stylesheet">
<link href="{{asset('css/fonts.css')}}" rel="stylesheet">
<!-- CSS -->
<link href="{{asset('css/app.css')}}" rel="stylesheet">
<link href="{{asset('css/navbar.css')}}" rel="stylesheet">
@yield('oneprod')
@yield('authcss')
@yield('prodscss')
@yield('profilecss')
@yield('addprod')
@yield('slidercss')
@yield('cartcss')
@yield('paymentcss')