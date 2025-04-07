@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}" />
@endsection

@section('content')
<div class="thanks__container">
    <div class="thanks__wrapper">
        <p class="message">会員登録ありがとうございます</p>
        <a class="btn" href="/">ログインする</a>
    </div>
</div>
@endsection