@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
@endsection

@section('content')
<div class="login__container">
    <p class="ttl">Login</p>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="email__wrapper">
            <img class="email__icon" src="{{ asset('img/email.png') }}" alt="アイコン">
            <input class="email__input" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email">
            <div class="form__error">
                @error('email') {{ $message }} @enderror
            </div>
        </div>
        <div class="password__wrapper">
            <img class="password__icon" src="{{ asset('img/password.png') }}" alt="アイコン">
            <input class="password__input" type="password" name="password" placeholder="Password">
            <div class="form__error">
                @error('password') {{ $message }} @enderror
            </div>
        </div>
        <div class="btn__wrapper">
            <button class="btn" name="login-btn" type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection