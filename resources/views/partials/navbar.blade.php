<div class="nav-underline">
    <nav class="mini-container">
        <div class="navbar-top">

            <div class="flex flex-start ms-auto nav-3">
                <a href="{{ url('/') }}" value="main" class="nav-link t-link" >ГОЛОВНА</a>
                <a href="{{ url('/') }}?sex=f" value="women" class="nav-link t-link">ЖІНКАМ</a>
                <a href="{{ url('/') }}?sex=m" value="men" class="nav-link t-link">ЧОЛОВІКАМ</a>
                <a href="{{ url('/') }}?sex=c" value="kids" class="nav-link t-link">ДІТЯМ</a>
            </div>

            <a class="navbar-title fs32 fw700 nav-3" href="{{ url('/') }}">
                {{ config('BestBrand', 'BestBrands') }}
            </a>

            <div class="nav-icons nav-3">
                <a class="nav-btn" href="/search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3528 9.67638C17.3528 13.9163 13.9163 17.3528 9.67638 17.3528C5.43646 17.3528 2 13.9163 2 9.67638C2 5.43646 5.43646 2 9.67638 2C13.9163 2 17.3528 5.43646 17.3528 9.67638Z" stroke="#1D1E20" stroke-width="2" stroke-linecap="round"/>
                        <path d="M21.6708 21.671L15.4337 15.4339" stroke="#1D1E20" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        
                </a>
                <a class="nav-btn" href="/profile">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 22.0002V19.6668C22 18.4292 21.4732 17.2422 20.5355 16.367C19.5979 15.4918 18.3261 15.0002 17 15.0002H7C5.67392 15.0002 4.40215 15.4918 3.46447 16.367C2.52678 17.2422 2 18.4292 2 19.6668V22.0002" stroke="#1D1E20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.0002 12.0002C14.7617 12.0002 17.0002 9.76161 17.0002 7.00018C17.0002 4.23876 14.7617 2.00018 12.0002 2.00018C9.23882 2.00018 7.00024 4.23876 7.00024 7.00018C7.00024 9.76161 9.23882 12.0002 12.0002 12.0002Z" stroke="#1D1E20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                </a>
                <a class="nav-btn" id="cart-icon" href="/cart">
                    <div class="rel">
                        @if($gpersonal > 0 )
                            <svg id="cart-num" class="overflow" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="6 6 20 21" fill="none">
                                <circle cx="10" cy="10" r="10" fill="#74747B"/>
                                <text id="cart-count" x="5.5" y="15" fill="white">{{$gpersonal}}</text>
                            </svg>
                        @endif
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_18_139)">
                            <path d="M5.75 5C5.19772 5 4.75 5.44772 4.75 6C4.75 6.55228 5.19772 7 5.75 7V5ZM6.47727 13.25C5.92499 13.25 5.47727 13.6977 5.47727 14.25C5.47727 14.8023 5.92499 15.25 6.47727 15.25V13.25ZM19.6397 12.8397L18.6841 12.5448L19.6397 12.8397ZM21.3505 7.29483L20.3949 7L21.3505 7.29483ZM5.75 7H20.3949V5H5.75V7ZM20.3949 7L18.6841 12.5448L20.5952 13.1345L22.306 7.58965L20.3949 7ZM17.7286 13.25H6.47727V15.25H17.7286V13.25ZM18.6841 12.5448C18.5548 12.964 18.1673 13.25 17.7286 13.25V15.25C19.0447 15.25 20.2072 14.3921 20.5952 13.1345L18.6841 12.5448ZM20.3949 7H20.3949L22.306 7.58965C22.703 6.30323 21.7412 5 20.3949 5V7Z" fill="#1D1E20"/>
                            <path d="M2.5 1.5C1.94772 1.5 1.5 1.94772 1.5 2.5C1.5 3.05228 1.94772 3.5 2.5 3.5V1.5ZM5.125 2.5L6.1205 2.40519C6.07162 1.89196 5.64056 1.5 5.125 1.5V2.5ZM17.5 19.25C18.0523 19.25 18.5 18.8023 18.5 18.25C18.5 17.6977 18.0523 17.25 17.5 17.25V19.25ZM2.5 3.5H5.125V1.5H2.5V3.5ZM4.1295 2.59481L5.45709 16.5344L7.44808 16.3448L6.1205 2.40519L4.1295 2.59481ZM8.44357 19.25H17.5V17.25H8.44357V19.25ZM5.45709 16.5344C5.60373 18.0741 6.8969 19.25 8.44357 19.25V17.25C7.92802 17.25 7.49696 16.858 7.44808 16.3448L5.45709 16.5344Z" fill="#1D1E20"/>
                            <circle cx="16.25" cy="21.75" r="1.25" fill="#1D1E20"/>
                            <circle cx="8.5" cy="21.75" r="1.25" fill="#1D1E20"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_18_139">
                            <rect width="24" height="24" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </div>
                </a>
                @if($profile != null)
                    @if($profile->role != 'u')  
                        <a class="nav-btn" href="/addprod">
                            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m11 11h-7.25c-.414 0-.75.336-.75.75s.336.75.75.75h7.25v7.25c0 .414.336.75.75.75s.75-.336.75-.75v-7.25h7.25c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-7.25v-7.25c0-.414-.336-.75-.75-.75s-.75.336-.75.75z" fill-rule="nonzero"/></svg>
                        </a>
                    @endif
                @endif
            </div>
            <div id="cart-prev" data-id="{{Auth::id()}}" style="display: none">
                <h2 id="cart-title" class="fw400 fs15 txt-centered cE20">Кошик ()</h2>
                <hr id="cart-ins">

                <hr>
                <div class="flex flex-between mb24">
                    <h1 class="fs16 fw700 cE20">РАЗОМ</h1>
                    <h1 class="fs16 fw700 cE20" id="cart-total-price"></h1>
                </div>
                <a href="/cart" class="btn fill-btn fix-btn fs15 fw500">Перейти до замовлення</a>
            </div>
        </div>
        <div class="sub-header"></div>
    </nav>
</div>
<div class="nav-underline">
    <nav class="mini-container">
        <div class="nav-bottom nav-3">
            <div id="main" class="flex flex-start category-nav w-30">
                <a class="nav-link b-link" value="m1">КАТЕГОРІЇ</a>
                <a class="nav-link b-link" value="m2">БРЕНДИ</a>
            </div>
            <div id="women" class="flex flex-start category-nav w-30 blink-a">
                <a class="nav-link b-link" value="w1">ЖІНКИ 1</a>
                <a class="nav-link b-link" value="w2">ЖІНКИ 2</a>
                <a class="nav-link b-link" value="w3">ЖІНКИ 3</a>
                <a class="nav-link b-link" value="w4">ЖІНКИ 4</a>
                <a class="nav-link b-link" value="w5">ЖІНКИ 5</a>
            </div>
            <div id="men" class="flex flex-start category-nav w-30">
                <a class="nav-link b-link" value="m1">ЧОЛОВІ 1</a>
                <a class="nav-link b-link" value="m2">ЧОЛОВІ 2</a>
                <a class="nav-link b-link" value="m3">ЧОЛОВІ 3</a>
                <a class="nav-link b-link" value="m4">ЧОЛОВІ 4</a>
                <a class="nav-link b-link" value="m5">ЧОЛОВІ 5</a>
            </div>
            <div id="kids" class="flex flex-start category-nav w-30">
                <a class="nav-link b-link" value="k1">ДІТИ 1</a>
                <a class="nav-link b-link" value="k2">ДІТИ 2</a>
                <a class="nav-link b-link" value="k3">ДІТИ 3</a>
                <a class="nav-link b-link" value="k4">ДІТИ 4</a>
                <a class="nav-link b-link" value="k5">ДІТИ 5</a>
            </div>
        </div>
    </nav>
</div>
<nav class="nav-info">
    <div>
        <div id="m1" class="info-block">
            @foreach($categories as $category)
                @if($category->parent_id == 0)
                    <a href="?pcat={{$category->id}}">{{$category->name}}</a>
                    <ul>
                        @foreach($categories as $cat)
                            @if($cat->parent_id == $category->id)
                                @if(array_search($cat->id, array_column((array)$category, 'parent_id')) == FALSE)
                                    <li>
                                        <a href="?cat={{$cat->id}}">{{$cat->name}}</a>
                                    </li>
                                @else
                                    <a href="?pcat={{$cat->id}}">{{$cat->name}}</a>
                                    <ul>
                                        @foreach($categories as $c)
                                            @if($c->parent_id == $cat->id)
                                                <li>
                                                    <a href="?cat={{$c->id}}">{{$c->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </div>
        <div id="m2" class="info-block">
            <ul>
                @foreach($brands as $brand)
                    <li><a href="?b={{$brand->id}}">{{$brand->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div>
        <div id="w1" class="info-block">
            <h5>W1 Header</h5>
            <a href="">W1</a>
            <a href="">W1</a>
        </div>
        <div id="w2" class="info-block">
            W2 WAHDAWGV DHAJWYGD AWGD KAW
            W2
        </div>
        <div id="w3" class="info-block">
            W3
            W3
        </div>
        <div id="w4" class="info-block">
            W4
            W4
        </div>
        <div id="w5" class="info-block">
            W5
            W5
        </div>
    </div>
    <div>
        <div id="m1" class="info-block">
            TEST
            TEST
        </div>
        <div id="m2" class="info-block">
            TEST
            TEST
        </div>
        <div id="m3" class="info-block">
            TEST
            TEST
        </div>
        <div id="m4" class="info-block">
            TEST
            TEST
        </div>
        <div id="m5" class="info-block">
            TEST
            TEST
        </div>
    </div>
    <div>
        <div id="k1" class="info-block">
            TEST
            TEST
        </div>
        <div id="k2" class="info-block">
            TEST
            TEST
        </div>
        <div id="k3" class="info-block">
            TEST
            TEST
        </div>
        <div id="k4" class="info-block">
            TEST
            TEST
        </div>
        <div id="k5" class="info-block">
            TEST
            TEST
        </div>
    </div>

</nav>

@section('navjs')
    <script src="{{asset('js/jnav.js')}}"></script>
@endsection