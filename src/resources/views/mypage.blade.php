@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
<div class="mypage__container">
    <h1 class="page__name">testさん</h1>
    <div class="content__wrapper">
        <div class="right__wrapper">
            <h3 class="item__name">予約状況</h3>
            @for($i = 0; $i < count($reservations); $i++)
                <div class="reservation__card">
                <div class="card__header">
                    <div class="card__ttl">
                        <img src="{{asset('img/clock.png')}}" alt="時計">
                        <span>予約{{$i+1}}</span>
                    </div>
                    <form class="card__delete" action="/mypage/reservation/delete" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{ $reservations[$i]->id }}">
                        <button type="submit">×</button>
                    </form>
                </div>
                <form class="card-content__form" action="/mypage/update" method="post">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="id" value="{{ $reservations[$i]->id}}">
                    <table class="card__content">
                        <tr class="table__row">
                            <td class="table__header">Shop</td>
                            <td class="table__data">{{ $reservations[$i]->shop->name }}</td>
                        </tr>
                        <tr class="table__row">
                            <td class="table__header">Date</td>
                            <td class="table__data">
                                <input type="date" name="date" value="{{ $reservations[$i]->date }}">
                                <div class="form__error">
                                    @error('date') {{ $message }} @enderror
                                </div>
                            </td>
                        </tr>
                        <tr class="table__row">
                            <td class="table__header">Time</td>
                            <td class="table__data">
                                <select class="time" name="time">
                                    @for($j = 9; $j < 24; $j++)
                                        <option value="{{$j}}:00" {{ old('time', substr($reservations[$i]->time, 0, 5))=="$j:00" ? 'selected' : '' }}>{{$j}}:00</option>
                                        @endfor
                                </select>
                                <div class="form__error">
                                    @error('time') {{ $message }} @enderror
                                </div>
                            </td>
                        </tr>
                        <tr class="table__row">
                            <td class="table__header">Number</td>
                            <td class="table__data">
                                <select class="number" name="number">
                                    @for($j = 1; $j < 9; $j++)
                                        <option value="{{$j}}" {{ old('number', $reservations[$i]->number)=="$j" ? 'selected' : '' }}>{{$j}}人</option>
                                        @endfor
                                </select>
                                <div class="form__error">
                                    @error('number') {{ $message }} @enderror
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="update__btn">
                        <button type="submit">変更する</button>
                    </div>
                </form>
                <form class="qr__form" action="/mypage/{{ $reservations[$i]->id }}/qr" method="get">
                    <button type="submit">QRコード</button>
                </form>
        </div>
        @endfor
    </div>
    <div class="left__wrapper">
        <h3 class="item__name">お気に入り店舗</h3>
        <div class="shop-card__wrapper">
            @foreach($favoriteShops as $shop)
            <div class="shop-card">
                <img src="{{ asset('storage/'.$shop->image) }}" alt="">
                <p class="name">仙人</p>
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
    </div>
</div>
</div>
@endsection