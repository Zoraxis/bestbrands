<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="load">
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div id="overlay" style="display: none">
        <div id="cover" onclick="$(this).parent().fadeOut('fast', ()=>{$('#over-content').empty()})"></div>
        <div id="over-content">
        </div>
    </div>

    <script src="{{asset('js/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('js/jnav.js')}}"></script>
    @yield('sliderjs')
    @yield('profilejs')
    @yield('oneprodjs')
    @yield('addprodjs')
    @yield('cartjs')
    @yield('paymentjs')
</body>
</html>
