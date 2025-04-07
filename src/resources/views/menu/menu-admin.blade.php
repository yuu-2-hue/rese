@extends('layouts/menu-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}" />
@endsection

@section('content')
<div class="menu__container">
    <a class="link" href="/">Home</a>
    <form class="form" action="/logout" method="post">
        @csrf
        <button class="btn" href="/login">Logout</button>
    </form>
    <a class="link" href="/admin">Admin</a>
</div>
@endsection