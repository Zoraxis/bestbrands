@extends('layouts.app')

@section('oneprod')
    <link href="https://fonts.cdnfonts.com/css/inter" rel="stylesheet">
    <link href="{{asset('css/oneproduct.css')}}" rel="stylesheet">
@endsection
@section('slidercss')
    <link rel="stylesheet" href="{{asset('css/slider.css')}}">
@endsection


@section('content')
    <div class="mini-container top-offset product">
        <div class="picture-container">
            <div class="slider">
                <a class="next arr control pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="29" viewBox="0 0 17 29" fill="none">
                        <path d="M1 1L15 14.5L1 28" stroke="white" stroke-width="2.5"/>
                    </svg>
                </a>
                <a class="prev arr control pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="29" viewBox="0 0 17 29" fill="none">
                        <path d="M15.5 1L2 14.5L15.5 28" stroke="white" stroke-width="2.5"/>
                    </svg>
                </a>
                <div class="img-prev control">
                    <img data-id="1" class="pointer slider-option active-slide" src="{{asset('images/'.$product['image'])}}">
                    <img data-id="2" class="pointer slider-option" src="{{asset('images/'.$product['image2'])}}">
                    <?php $i = 2?>
                    @if ($product->images != null)
                        @foreach($product->images as $img)
                            <?php $i++;?>
                            <img data-id="{{$i}}" class="pointer slider-option" id="i{{$i}}" src="{{asset('images/'.$img)}}">
                        @endforeach
                    @endif
                </div>
                <ul>
                    <img id="i1" src="{{asset('images/'.$product->image)}}" >
                    <img id="i2" src="{{asset('images/'.$product->image2)}}">
                    <?php $i = 2?>
                    @if ($product->images != null)
                        @foreach($product->images as $img)
                            <?php $i++;?>
                            <img id="i{{$i}}" src="{{asset('images/'.$img)}}">
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="product-description">
            <h5 class="fs20 fw500"></h5>
            <h2 class="title">{{$product['name']}}</h2>
            <p class="fs22 fw500">{{$product['content']}}</p>
            <h5 class="fs26 fw600">{{$product['price']}}₴</h5>
            <h5 class="fs20 fw500 c47B">Колір: <span class="black">Чорний</span></h5>
            <div class="sizes">
                <div class="size-header c47B">
                    <div class="fw400 fs20">Оберiть розмір:</div>
                    <div class="size-grid pointer">Розмірна сітка</div>
                </div>
                <div id="size-list">
                    <?php
                        $sizes = explode(" ", $product->sizes);
                        foreach ($sizes as $num => $size) {
                            $s = "<div class=\"box ";
                            if (strval(substr($size, strpos($size, '.')+1)) == 0) { $s .= 'outof';}
                            $s .="\">".substr($size, 0, strpos($size, '.'))."</div>";
                            echo $s;
                        }
                    ?>
                </div>
            </div>
            <a onclick="ToggleCart('{{$product->id}}', 'c')">
                 <div id="add-cart-btn" class="fill-btn fs18 fw500 btn mb16 fix-btn">
                    {{-- <div>Дода@if(!$personal->is_cart)ти@elseно@endif до кошику</div> --}}
                    <div>Додати до кошику</div>
                </div> 
            </a>
            <a onclick="ToggleCart('{{$product->id}}', 'w')">
                <div class="button outline-btn fs18 fw500 btn">
                    <svg id="wishlist" class="icon" xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="
                    @if($personal->is_wishlist)
                    red
                    @else
                    white
                    @endif
                    ">
                        <path d="M11 5.5C11 5.5 13.0083 1 16.6374 1C20.2664 1 21.9283 6.44395 18.9979 9.36599C16.0676 12.288 11 17 11 17" stroke="#222220" stroke-width="1.75" stroke-linecap="round"/>
                        <path d="M11 5.49999C11 5.49999 8.99166 1 5.36262 1C1.73359 1 0.0717139 6.44395 3.00205 9.36599C5.93239 12.288 11 17 11 17" stroke="#222220" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="btn-title">Вішліст</div>
                    <div></div>
                </div>
            </a>
            <div class="err">
                @if(session()->has('error'))
                {{session('error')}}
                    <h5 class="fs20 fw500">Не Увiйшли в аккаунт!
                        <a href="/login" class="underline c47B btn link">Увiйти</a>
                    </h5>
                @endif
            </div>
            @if($profile != null)
                @if($profile->role != 'u')
                     <div id="del-item-btn" data-id="{{$product->id}}" class="fill-btn fs18 fw500 btn mb16 fix-btn">
                        <div>Видалити Товар</div>
                    </div> 
                @endif
            @endif


        </div>
    </div>

    
@endsection

@section('oneprodjs')
    <script src="{{asset('js/oneprod.js')}}"></script>
@endsection
@section('sliderjs')
    <script src="{{asset('js/slider.js')}}"></script>
@endsection