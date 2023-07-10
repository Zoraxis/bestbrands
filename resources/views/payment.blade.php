@extends('layouts.simple')


@section('paymentcss')
    <link rel="stylesheet" href="{{asset('css/payment.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile/card.css')}}">
@endsection

@section('content')
<div class="flex no-overflow">
    <div id="main-screen">
        <div class="header">
            <h1 class="fw700 fs32 txt-centered overflow">BRAND STORE</h1>
        </div>
        <div id="pay-nav">
            <div id="graphics" class="flex allign-center">
                <div class="circle">
                    <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                        <circle cx="23" cy="23" r="22.125" stroke="#1D1E20" stroke-width="1.75"/>
                        <text id="n1" class="fs26 fw400" x="16" y="30" fill="#1D1E20">1</text>
                        <path style="display: none" id="tick1" transform="translate(15,15)"  d="M1 6.4L7.76923 13L17 1" stroke="#1D1E20" stroke-width="2"/>
                    </svg>
                </div>
                <div class="line">
                    <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="175" height="2" viewBox="0 6 175 2" fill="none">
                        <path d="M0 1H175" stroke="#1D1E20" stroke-width="1.75"/>
                    </svg>
                </div>
                <div class="circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                        <circle cx="23" cy="23" r="22.125" stroke="#1D1E20" stroke-width="1.75"/>
                        <text id="n2" class="fs26 fw400" x="16" y="30" fill="#1D1E20">2</text>
                        <path style="display: none" id="tick2" transform="translate(15,15)"  d="M1 6.4L7.76923 13L17 1" stroke="#1D1E20" stroke-width="2"/>
                    </svg>
                </div>
                <div class="line">
                    <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="175" height="2" viewBox="0 6 175 2" fill="none">
                        <path d="M0 1H175" stroke="#1D1E20" stroke-width="1.75"/>
                    </svg>
                </div>
                <div class="circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                        <circle cx="23" cy="23" r="22.125" stroke="#1D1E20" stroke-width="1.75"/>
                        <text class="fs26 fw400" x="16" y="30" fill="#1D1E20">3</text>
                    </svg>
                </div>
            </div>
            <div id="graph-cover" style="left: 543px;"></div>
            <div id="signs" class="flex flex-between">
                <h2 class="fw700 fs14">Контактнi данi</h2>
                <h2 class="fw700 fs14">Адреса доставки</h2>
                <h2 class="fw700 fs14">Спосiб оплати</h2>
            </div>
            <div id="sign-cover" style="left: 678px;"></div>
        </div>
        <div id="slides">
            <div class="slide aslide" id="s1">
                <h1 class="fs26 fw500">Персональна Iнформацiя</h1>
                <hr>
                @if($profile->telephone == null)
                <div class="inputs mb36">
                    <div class="input">
                        <label for="tel">Телефон</label>
                        <input id="tel" type="text"/>
                    </div>
                </div>
                @else
                    <div class="flex allign-center mb36">
                        <svg class="mr16" xmlns="http://www.w3.org/2000/svg" width="26" height="21" viewBox="0 0 26 21" fill="none">
                            <path d="M2 9.2L11.3077 18L24 2" stroke="#44823E" stroke-width="4"/>
                        </svg>
                        <h1 class="fw500 fs28">Усi контактнi данi вже вказано!</h1>
                    </div>
                @endif
                <div class="flex flex-between txt-centered">
                    <a class="btn outline-btn f33 prev">Назад</a>
                    <a class="btn fill-btn f65 next">Продовжити</a>
                </div>
            </div>
            <div class="slide" id="s2" style="display:none">
                <h1 class="fs26 fw500">Деталі доставки</h1>
                <a href="/profile" target="_blank" id="add-address-btn" class="underline pointer c47B prev">
                    Додати ще
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path transform="scale(1)" fill="#74747B" d="M21 13v10h-21v-19h12v2h-10v15h17v-8h2zm3-12h-10.988l4.035 4-6.977 7.07 2.828 2.828 6.977-7.07 4.125 4.172v-11z"/></svg></a>
                <hr>
                <div class="tab mb26" id="paddress">
                    
                </div>
                <div class="flex flex-between txt-centered">
                    <a class="btn outline-btn f33 prev">Назад</a>
                    <a class="btn fill-btn f65 next locked" id="next-to-card">
                        <svg class="overflow" id="address-lock" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 -3 18 18" fill="none">
                                <path d="M2 8.83301V14.583C2 15.4114 2.67157 16.083 3.5 16.083H14.5C15.3284 16.083 16 15.4114 16 14.583V8.83301C16 8.00458 15.3284 7.33301 14.5 7.33301H3.5C2.67157 7.33301 2 8.00458 2 8.83301Z" stroke="white" stroke-width="1.5"/>
                                <path d="M5.5 7.5V4.5C5.5 2.84315 6.84315 1.5 8.5 1.5H9.5C11.1569 1.5 12.5 2.84315 12.5 4.5V7.5" stroke="white" stroke-width="1.5"/>
                                <path d="M9 10.5V13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Продовжити</a>
                </div>
            </div>
            <div class="slide" id="s3" style="display:none">
                <h1 class="fs26 fw500">Збережені картки</h1>
                <a href="/profile" target="_blank" onclick="location.reload()" class="underline pointer c47B ">
                    Додати ще
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path transform="scale(1)" fill="#74747B" d="M21 13v10h-21v-19h12v2h-10v15h17v-8h2zm3-12h-10.988l4.035 4-6.977 7.07 2.828 2.828 6.977-7.07 4.125 4.172v-11z"/></svg>
                </a>
                <hr>
                <div id="cards" class="mb36"></div>
                <div class="flex flex-between txt-centered">
                    <a class="btn outline-btn f33 prev">Назад</a>
                    <a class="btn fill-btn f65 next locked">
                        <svg class="overflow" id="card-lock" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 -3 18 18" fill="none">
                            <path d="M2 8.83301V14.583C2 15.4114 2.67157 16.083 3.5 16.083H14.5C15.3284 16.083 16 15.4114 16 14.583V8.83301C16 8.00458 15.3284 7.33301 14.5 7.33301H3.5C2.67157 7.33301 2 8.00458 2 8.83301Z" stroke="white" stroke-width="1.5"/>
                            <path d="M5.5 7.5V4.5C5.5 2.84315 6.84315 1.5 8.5 1.5H9.5C11.1569 1.5 12.5 2.84315 12.5 4.5V7.5" stroke="white" stroke-width="1.5"/>
                            <path d="M9 10.5V13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Оплатити</a>
                </div>
            </div>
            <div class="slide" id="s4" style="display:none"></div>
            
        </div>
        
    </div>
    <?php $weight = 0; $price = 0;?>
    <div id="cart">
        <h2 class="fs17 fw400">КОШИК ({{count($items)}})</h2>
        @foreach($items as $item)
            <?php $weight += $item->weight*$item->quant; $price += $item->price* $item->quant;?>
            <hr>
            <div class="cart-prev-el flex mb14">
                <img src="{{asset('images/'.$item->image)}}"/>
                <div class="cart-prev-desc">
                    <h2 class="fw700 fs16 mb8">{{$item->name}}</h2>
                    <h2 class="fw400 fs10 c47B mb14">{{$item->content}}</h2>
                    <div class="fw400 fs10 c47B mb14 cart-det">
                        <div>{{$item->sz}}</div>
                        <div>
                            <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="3" height="3" viewBox="0 0 3 3" fill="none">
                                <circle cx="1.5" cy="0" r="1.5" fill="#C9C9CF"/>
                            </svg>
                        </div>
                        <div>Кiлькiсть: {{$item->quant}}</div>
                    </div>
                    <h2 class="fs12 fw700 cE20">{{$item->price * $item->quant}}₴</h2>
                </div>
            </div>
        @endforeach
        <div data-weight="{{$weight}}" data-price="{{$price}}" id="data-export"></div>
        <div id="total">
            <div class="row">
                <h2 class="fs16 fw700">РАЗОМ</h2>
                <h2 class="fs16 fw700"><span id="total-cart-cost">---</span>₴</h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('paymentjs')
    <script src="{{asset('js/payment.js')}}"></script>
@endsection