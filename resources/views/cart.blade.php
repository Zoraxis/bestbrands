@extends('layouts.app')

@section('cartcss')
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap'); </style>
@endsection

@section('content')
    <div class="cart-container mt62 flex fontM">
        <div class="items-container">
            <h1 class="fs26 fw500">Кошик (<span id="total-cart-count">{{count($items)}}</span>)</h1>
            <?php $price = 0; $weight = 0 ?>
            @foreach($items as $item) 
                <?php $price += $item->price;?>
                <?php $weight += $item->weight;?>
                <hr>
                <div data-sz="{{$item->sz}}" data-id="{{$item->id}}" data-weight="{{$item->weight}}" data-price="{{$item->price}}" class="cart-el flex">
                    <img src="{{asset('images/'.$item->image)}}"/>
                    <div class="cart-prev-desc">
                        <h2 class="fw700 fs20 mb8">{{$item->name}}</h2>
                        <h2 class="fw400 fs14 c47B mb14">{{$item->content}}</h2>
                        <div class="fw400 fs14 c47B mb14 cart-det">
                            <div>{{$item->sz}}</div>
                            <div>
                                <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="3" height="3" viewBox="0 0 3 3" fill="none">
                                    <circle cx="1.5" cy="0" r="1.5" fill="#C9C9CF"/>
                                </svg>
                            </div>
                            <div class="count-det"><span>Кiлькiсть:</span><span class="item-count">{{$item->quant}}</span></div>
                        </div>
                        <h2 class="fs16 fw700 cE20 mb24"><span data-price="{{$item->price}}" class="item-price">{{$item->price * $item->quant}}</span><span>₴</span></h2>
                        @if($item->maxCount > 1)
                            <div class="flex allign-center mb48">
                                <h2 class="fw400 fs14 c47B mr16">Кiлькiсть:</h2>
                                <a class="pointer minus-icon" @if($item->quant == 1)disabled @endif>
                                    <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="8" height="2" viewBox="0 3 8 2" fill="none">
                                        <path d="M0 1H8" stroke="@if($item->quant == 1)#74747B @else#1D1E20 @endif" stroke-width="1.25"/>
                                    </svg>
                                </a>
                                <span data-max="{{$item->maxCount}}" class="count-display">{{$item->quant}}</span>
                                <a class="pointer plus-icon" @if($item->count == $item->maxCount)disabled @endif>
                                    <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 1 8 8" fill="none">
                                        <path d="M4 0V8" stroke="@if($item->quant == $item->maxCount)#74747B @else#1D1E20 @endif" stroke-width="1.25"/>
                                        <path d="M0 4H8" stroke="@if($item->quant == $item->maxCount)#74747B @else#1D1E20 @endif" stroke-width="1.25"/>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <h2 class="fs14 fw400 c47B mb48">1 ЕКЗЕМПЛЯР НА СКЛАДI</h2>
                        @endif
                        <div class="row allign-center" data-sz="{{$item->sz}}" data-id="{{$item->id}}">
                            <a class="cart-del cA60 fs16 fw400 pointer h-underline">Видалити із корзини</a>
                            <svg class="overflow dot-separator" xmlns="http://www.w3.org/2000/svg" width="3" height="3" viewBox="0 0 3 3" fill="none">
                                <circle cx="1.5" cy="0" r="1.5" fill="#C9C9CF"/>
                            </svg>
                            <a class="cart-wishlist cA60 fs16 fw400 pointer h-underline">Додати до вішліста</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div id="data-export" data-weight="{{$weight}}" data-price="{{$price}}" style="display: none"></div>
        </div>
        <div class="summary-container">
            <h2 class="fw500 fs26">Підсумок Замовлення</h2>
            <hr>
            <div class="row fw400 fs20">
                <span>Пiдсумок</span>
                <div><span id="cart-price">{{$price}}</span><span>₴</span></div>
            </div>
            <div class="row fw400 fs20">
                <span>Пересилка</span>
                <div><span id="ship-price">----</span><span>₴</span></div>
            </div>
            <hr>
            <div class="row fw700 fs20 mb24">
                <span>Разом</span>
                <div><span id="total-price">----</span><span>₴</span></div>
            </div>
            <a @if(count($items)>0) href="payment" @endif class="btn fill-btn fix-btn @if(count($items)<1) o70 @endif" >Оплатити</a>
        </div>
    </div>
@endsection

@section('cartjs')
    <script src="{{asset('js/cart.js')}}"></script>
@endsection