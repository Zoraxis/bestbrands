@extends('layouts.app')

@section('oneprod')
    <link href="https://fonts.cdnfonts.com/css/inter" rel="stylesheet">
    <link href="{{asset('css/oneproduct.css')}}" rel="stylesheet">
@endsection
@section('addprod')
    <link href="{{asset('css/addprod.css')}}" rel="stylesheet">
@endsection
@section('slidercss')
    <link rel="stylesheet" href="{{asset('css/slider.css')}}">
@endsection


@section('content')
    <div class="mini-container top-offset product">
        <div class="picture-container">
            <form id="img-form">
                <div class="fix-btn">
                    <label for="img" class="btn fill-btn addf-label">Додати Фото</label>
                    <input type="file" name="image" style="display:none;" id="img"/>
                </div>
            </form>
            <div class="slider" style="display: none">
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
                <div class="img-prev control img-predest">
                </div>
                <ul class="img-dest">
                </ul>
            </div>
            
            <span id="error_div"></span>
            <div class="images"></div>
        </div>
        <div class="product-description">
            <h5 class="fs20 fw500"></h5>
            <div class="inputs">
                <label class="input">
                    <small class="c47B">Бренд</small>
                    <select class="title" type="text" id="brand">
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </label>
                <label class="input">
                    <small class="c47B">Категорiя</small>
                    <select class="title" type="text" id="category">
                        @foreach($categories as $category)
                            @if($category->parent_id != null)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </label>
                <label class="input">
                    <small class="c47B">Тип</small>
                    <select class="title" type="text" id="sex">
                        <option value="m">Жiнка</option>
                        <option value="f">Чоловiк</option>
                        <option value="u">Унiсєкс</option>
                        <option value="g">Дiвчинка</option>
                        <option value="b">Хлопчик</option>
                        <option value="c">Унiсєкс дитячий</option>
                    </select>
                </label>
                <label class="input">
                    <small class="c47B">Головне фото</small>
                    <select class="title" type="text" id="img1">
                    </select>
                </label>
                <label class="input">
                    <small class="c47B">Друге фото</small>
                    <select class="title" type="text" id="img2">
                    </select>
                </label>
                <label class="input">
                    <small class="c47B">Назва</small>
                    <input type="text" id="name">
                </label>
                <label class="input">
                    <small class="c47B">Цiна(₴)</small>
                    <input type="number" id="price">
                </label>
                <label class="input">
                    <small class="c47B">Вага(кг)</small>
                    <input type="number" id="weight">
                </label>
            </div>
            {{-- <h5 class="fs20 fw500 c47B">Колір: <span class="black">Чорний</span></h5> --}}
            <div class="sizes">
                <div class="size-header c47B">
                    <div class="fw400 fs20">Розмір:</div>
                    <div class="size-grid pointer">Розмірна сітка</div>
                </div>
                <div id="size-list">
                    <div class="box box-s" id="add-size">
                        <input type="text" id="text">
                        <input type="number" id="count">
                        <svg width="24px" onclick="addSize()" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m11 11h-7.25c-.414 0-.75.336-.75.75s.336.75.75.75h7.25v7.25c0 .414.336.75.75.75s.75-.336.75-.75v-7.25h7.25c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-7.25v-7.25c0-.414-.336-.75-.75-.75s-.75.336-.75.75z" fill-rule="nonzero"/></svg>
                    </div>
                </div>
            </div>
            <a>
                <div class="fill-btn fs18 fw500 btn mb16 fix-btn" id="add-item">Додати</div> 
            </a>


        </div>
    </div>

    
@endsection

@section('oneprodjs')
    <script src="{{asset('js/oneprod.js')}}"></script>
@endsection
@section('addprodjs')
    <script src="{{asset('js/addprod.js')}}"></script>
@endsection
@section('sliderjs')
    {{-- <script src="{{asset('js/slider.js')}}"></script> --}}
@endsection