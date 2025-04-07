@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}" />
@endsection

@section('content')
<div class="register__container">
    <p class="ttl">Registration</p>
    <form action="/register" method="post">
        @csrf
        <div class="name__wrapper">
            <img class="name__icon" src="{{ asset('img/username.png') }}" alt="アイコン">
            <input class="name__input" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Username">
            <div class="form__error">
                @error('name') {{ $message }} @enderror
            </div>
        </div>
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
            <button class="btn" name="login-btn" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection