@extends('layouts/menu-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}" />
@endsection

@section('content')
<div class="menu__container">
    <a class="link" href="/">Home</a>
    <a class="link" href="/register">Registration</a>
    <a class="link" href="/login">Login</a>
</div>
@endsection