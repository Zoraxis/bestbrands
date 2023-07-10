@extends('layouts.app')

@section('profilecss')
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    @if($profile->role != 'u')
        <link rel="stylesheet" href="{{asset('css/profile/admin.css')}}"/>
    @endif
@endsection

@section('content')
<div class="profile-tab">
    <div class="profile-nav">
        <a class="profile-link pl-active" data-content="main">Мої дані</a>
        <a class="profile-link" onclick="loadAddress()" data-content="address">Адреса</a>
        <a class="profile-link" onclick="loadCards()" data-content="pay">Способи оплати</a>
        <a class="profile-link" onclick="loadWishlist()" data-content="wishlist">Вішліст</a>
        <a class="profile-link" data-content="orders">Мої замовлення</a>
        <br>
        @if($profile->role != 'u')
            <a class="profile-link" onclick="loadCategories()" data-content="categories">Категорії</a>
            <a class="profile-link" onclick="loadBrands()" data-content="brands">Бренди</a>
            <a class="profile-link" onclick="loadSizes()"data-content="sizes">Розміри</a>
            <br>
        @endif
        <a class="profile-link" href="/ajax/profile/out">Вийти</a>
    </div>
    <div class="profile-content">
        <div class="tab" id="pmain">
            <div class="properties content-box">
                <div class="box-title fs26 fw500">Персональні дані</div>
                <div id="main-box" class="preview">
                    <div class="property">
                        {{$profile['surname']}}
                        {{$profile['name']}}
                        {{$profile['middlename']}}
                    </div>
                    <div class="property">
                        {{$profile['email']}}
                    </div>
                    <div class="property">
                        Telephone:
                        @if($profile['telephone'] != '')
                        {{$profile['telephone']}}
                        @else
                        Not Given
                        @endif
                    </div>
                    <hr class="box-hr">
                    <a data-edit="main-info" class="underline cE20 pointer edit-btn">Edit</a>
                </div>
                <div id="main-info" class="edit-mode" style="display:none">
                    <div class="inputs">
                        <label class="input">
                            Ім'я
                            <input type="text" id="name" value="{{$profile->name}}">
                            <div class="invalid"></div>
                        </label>
                        <label class="input">
                            Прізвище
                            <input type="text" id="surname" value="{{$profile->surname}}">
                            <div class="invalid"></div>
                        </label>
                        <label class="input">
                            По-батькові
                            <input type="text" id="middlename" value="{{$profile->middlename}}">
                            <div class="invalid"></div>
                        </label>
                        <label class="input">
                            Email
                            <input type="email" id="email" value="{{$profile->email}}">
                            <div class="invalid"></div>
                        </label>
                        <label class="input">
                            Телефон
                            <input placeholder="+(380) **-***-**-**" type="tel" id="tel"
                                value="{{$profile->telephone}}">
                            <div class="invalid"></div>
                        </label>
                    </div>
                    <a onclick="SaveData('main')" class="btn fill-btn save-btn fix-btn">Зберігти</a>
                </div>
            </div>
            <div class="targeting content-box">
                <div class="box-title fs26 fw500">Додаткова інформація</div>
                <div id="extra-box" class="preview">
                    <div class="property">
                        @if($profile->sex == 'u')
                        Стать не вказана
                        @elseif($profile->sex == 'f')
                        Мiс
                        @else
                        Мiстер
                        @endif
                    </div>
                    <div class="property">
                        @if($profile->birthday == null)
                        День Народження не вказан
                        @else
                        {{$profile->birthday}}
                        @endif
                    </div>
                    <hr class="box-hr">
                    <a data-edit="extra-info" class="underline cE20 pointer edit-btn">Edit</a>
                </div>

                <div id="extra-info" class="edit-mode" style="display: none">
                    <div class="inputs mb16">
                        <div class="explanation">
                            Розкажіть трохи про себе, щоб ми завжди могли підібрати вам цікаві товари
                        </div>
                        <label class="sinput mr24">
                            <small class="c47B">Стать</small>
                            <div class="toggle-radio txt-centered">
                                <input @if($profile['sex']=='m' ) checked @endif class="sex" style="display: none"
                                    type="radio" name="sex" id="male">
                                <input @if($profile['sex']=='f' || $profile['sex']=='u' ) checked @endif class="sex"
                                    style="display: none" type="radio" name="sex" id="female">
                                <div class="switch">
                                    <div class="options">
                                        <label class="pointer lever" for="male">Чоловiк</label>
                                        <label class="pointer lever" for="female">Жiнка</label>
                                        <div class="focus @if($profile['sex'] == 'm') left @endif"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="w432">
                            <small class="c47B">Отримуйте подарунки до Дня Народження</small>
                            <input id="birthday" type="date" value="{{$profile->birthday}}">
                        </label>
                    </div>
                    <a onclick="SaveExtraData('extra')" class="btn fill-btn save-btn fix-btn">Зберігти</a>
                </div>

            </div>
        </div>
        <div style="display: none" class="tab" id="paddress">
            <div class="properties content-box" style="display: none">
                <div id="address-info" class="fs28 fw500">Мої адреси</div>
                <a id="add-address-btn" class="underline pointer c47B">Додати ще</a>
            </div>
            <div class="properties content-box" id="no-address" style="display: none">
                <div id="address-info" class="fs22 fw500">Не знайдено жодної адреси</div>
                <a id="add-new-address-btn" class="underline pointer c47B">Додати Адресу</a>
            </div>

            <div data-action="no" class="properties content-box" id="ea-address" style="display: none">
                {{-- <div class="fs22 fw500">Add an address here</div> --}}
    
                <div class="toggle-radio txt-centered">
                    <input class="post-type" checked style="display: none" type="radio" name="sex" id="new">
                    <input class="post-type" style="display: none" type="radio" name="sex" id="ua">
                    <div class="switch">
                        <div class="options">
                            <label class="pointer lever" for="new">Нова Пошта</label>
                            <label class="pointer lever" for="ua">Укр Пошта</label>
                            <div class="addr-o focus left"></div>
                        </div>
                    </div>
                </div>
    
                <div class="inputs">
                    <label class="input">
                        Мiсто
                        <input type="text" id="city-post">
                        <small id="pcity-err"></small>
                        <div id="cities-dropdown" class="dropdown-content" >
                        </div>
                    </label>
                    <label class="input" style="display:none">
                        ID Почти
                        <input data-ref="" type="text" id="post-id">
                        <small id="pid-err"></small>
                        <div id="ids-dropdown" class="dropdown-content" >
                        </div>
                        <div class="invalid"></div>
                    </label>
                </div>
                <div>
                    <a onclick="SaveAddress()" style="display: none" id="post-save" class="btn fill-btn save-btn fix-btn">Зберігти</a>
                    <small id="form-err"></small>
                </div>
            </div>
        </div>
        <div style="display: none" class="tab" id="ppay">
            <div class="properties content-box">
                <div class="tab-title fs30 mb24">Способи оплати</div>
                <div id="cards" class="flex">
                    {{-- <img src="{{asset('images/card_1.png')}}"> --}}
                    <div class="card blank flex allign-center justify-center">
                        <a onclick="addCard()" class="pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 58 58" fill="none">
                                <rect x="0.625" y="0.625" width="56.75" height="56.75" rx="28.375" fill="white"/>
                                <g clip-path="url(#clip0_269_1334)">
                                    <path d="M29 21V37" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="square"/>
                                    <path d="M37 29H21" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="square"/>
                                </g>
                                <rect x="0.625" y="0.625" width="56.75" height="56.75" rx="28.375" stroke="#E4E4EB" stroke-width="1.25"/>
                                <defs>
                                    <clipPath id="clip0_269_1334">
                                        <rect width="24" height="24" fill="white" transform="translate(17 17)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none" class="tab" id="pwishlist">
            <div class="properties content-box">
                <div id="address-info" class="fs28 fw500">Мій Вішліст</div>
                <div class="wish items"></div>
            </div>
            
        </div>
        <div style="display: none" class="tab" id="porders">
            <div class="tab-title fs30">Мої дані</div>
            <hr>
        </div>
        @if($profile->role != 'u')
            <div style="display: none" class="tab" id="pcategories">
                <div class="properties content-box">
                    <div class="tab-title fs30">Категорії</div>
                </div>
            </div>
            <div style="display: none" class="tab" id="pbrands">
                <div class="properties content-box">
                    <div class="tab-title fs30">Бренди</div>
                </div>
            </div>
            <div style="display: none" class="tab" id="psizes">
                <div class="properties content-box">
                    <div class="tab-title fs30">Таблицi розмирiв</div>
                    <a id="new-sz" class="pointer underline c47B">Додати ще +</a>
                </div>
                <div class="properties content-box" id="sz-add" style="display: none">
                    <form id="sz-img">
                        <div class="inputs">
                            <div class="input">
                                <label>Зображення</label>
                                <label for="image" id="img-lbl"class="pointer btn outline-btn pbtn">обрати зображення</label>
                                <div><input type="file" id="image" name="image" style="overflow:hidden; display: none"></div>
                                <small id="sz-img-status"></small>
                            </div>
                            <div class="input">
                                <label for="sz-name">Опис</label>
                                <input id="sz-name" type="text">
                            </div>
                            <div class="input">
                                <label for="brand-sz">Бренд</label>
                                <select name="brand-sz" id="brand-sz">

                                </select>
                            </div>
                        </div>
                        <a class="btn fill-btn pbtn" onclick="addSizeGrid()">Додати</a>
                        <small id="sz-add-err"></small>
                    </form>
                </div>
            </div>
        @endif
    </div>
    
</div>
@endsection

@section('profilejs')
    <script src="{{asset('js/profile.js')}}"></script>
    @if($profile->role != 'u')
        <script src="{{asset('js/profile/admin.js')}}"></script>
    @endif
@endsection
