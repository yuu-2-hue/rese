@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}" />
@endsection

@section('content')
<div class="done__container">
    <div class="done__wrapper">
        <p class="message">ご予約ありがとうございます</p>
        <form class="form" action="/done/back" method="get">
            <button class="btn" type="submit">戻る</button>
        </form>
    </div>
</div>
@endsection