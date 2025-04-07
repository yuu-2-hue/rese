@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
<div class="search__wrapper">
    <form action="/" method="get">
        @csrf
        <select name="area" id="">
            <option disabled selected>All Area</option>
            @foreach($areas as $area)
            <option value="{{ $area->id }}" {{ old('area')==$area->id ? 'selected' : '' }}>{{ $area->area }}</option>
            @endforeach
        </select>
        <select name="genre" id="">
            <option disabled selected>All Genre</option>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}" {{ old('genre')==$genre->id ? 'selected' : '' }}>{{ $genre->genre }}</option>
            @endforeach
        </select>
        <input type="search" name="keyword" value="{{ old('keyword') }}" placeholder="Search ...">
    </form>
</div>
@endsection

@section('content')
<div class="content__container">
    @foreach($shops as $shop)
    <div class="card">
        <img src="{{ $shop->getFileUrl($shop->image) }}" alt="">
        <p class="name">{{ $shop->name }}</p>
        <span class="area">#{{ $shop->area->area }}</span>
        <span class="genre">#{{ $shop->genre->genre }}</span>
        <form class="form" action="{{ $shop->favored() ? '/unfavorite/'.$shop->id : '/favorite/'.$shop->id }}" method="post">
            @csrf
            <a class="detail__btn" href="/detail/{{$shop->id}}">詳しくみる</a>
            <button class="favorite__btn" type="submit">
                <img class="{{ $shop->favored() ? 'heart__favorite' : 'heart__unfavorite' }}" src="{{ asset('img/heart.png') }}" alt="ハート">
            </button>
        </form>
    </div>
    @endforeach
</div>
@endsection