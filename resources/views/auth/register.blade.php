@extends('layouts.app')

@section('authcss')
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="auth-container">
            <div class="fw400 fs28">{{ __('Реестрацiя') }}</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-item">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Iм\'я') }}</label>

                    <div class="input">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-item">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="input">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-item">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>

                    <div class="input">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-item">
                    <div class="input">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-end">{{ __('Пiдтвердження пароля') }}</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn fill-btn">
                            {{ __('Зарееструватися') }}
                        </button>
                    </div>
                </div>
                <hr>
                <div class="form-item">
                    <h3 class="fs20 fw400 txt-centered mb24">Вже маєте акаунт?</h3>
                    <a class="btn outline-btn fix-btn" href="/login">Увiйти</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
