@extends('layouts.app')

@section('authcss')
<link rel="stylesheet" href="{{asset('css/auth.css')}}">
@endsection

@section('content')
<div class="container">
    <div class=" justify-content-center">
        <div class="auth-container">
            <div class="fs28 fw400">{{ __('Логiн') }}</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-item">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="input">
                        <input class="form-control" id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                        <input class="form-control" id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-item">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link underline c47B fs14 fw400" href="{{ route('password.request') }}">
                        {{ __('Забули пароль?') }}
                    </a>
                    @endif
                </div>

                <div class="form-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Запам\'ятати мене') }}
                        </label>
                    </div>
                    <button class="fill-btn btn" type="submit">
                        {{ __('увiйти') }}
                    </button>
                </div>

                <hr>

                <div class="form-item txt-centered">
                    <h3 class="txt-centered fs20 fw400 mb24">Нема акаунту?</h3>
                    <a class="btn outline-btn fix-btn" href="/register">Створити новий</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
