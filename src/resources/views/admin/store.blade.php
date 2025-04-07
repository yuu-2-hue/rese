@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/store.css') }}" />
@endsection

@section('content')
<div class="store__container">
    <h2 class="page__ttl">店舗代表者作成</h2>
    <form class="form" action="/admin/store" method="post">
        @csrf
        <div class="form__item">
            <input type="text" name="name" placeholder="代表者名">
            <div class="form__error">
                @error('name') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <input type="mail" name="email" placeholder="mail@example.com">
            <div class="form__error">
                @error('email') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <input type="text" name="password" placeholder="パスワード">
            <div class="form__error">
                @error('password') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__button">
            <button type="submit">作成</button>
        </div>
    </form>
</div>
@endsection