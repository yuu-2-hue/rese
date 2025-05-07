@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
<div class="detail__container">
    <div class="top__wrapper">
        <div class="left__wrapper">
            <div class="left-content__header">
                <form class="form__back" action="/detail/1/back" method="get">
                    <button class="back__button" type="submit" name="back">＜</button>
                </form>
                <h2 class="shop__name">{{ $shop->name }}</h2>
            </div>
            <img class="shop__img" src="{{ asset('storage/'.$shop->image) }}" alt="">
            <div class="tag__wrapper">
                <span class="shop__tag">#{{ $shop->area->area }}</span>
                <span class="shop__tag">#{{ $shop->genre->genre }}</span>
            </div>
            <p class="shop__overview">
                {{ $shop->overview }}
            </p>
        </div>
        <div class="right__wrapper">
            <form class="form" action="/detail/reservation/{{$shop->id}}" method="post">
                @csrf
                <h2 class="right-content__ttl">予約</h2>
                <div class="right-content">
                    <input class="date" name="date" type="date">
                    <div class="form__error">
                        @error('date') {{ $message }} @enderror
                    </div>
                    <select class="time" name="time">
                        <option value="" selected="" disabled>未選択</option>
                        @for($i = 9; $i < 24; $i++)
                            <option value="{{$i}}:00">{{$i}}:00</option>
                            @endfor
                    </select>
                    <div class="form__error">
                        @error('time') {{ $message }} @enderror
                    </div>
                    <select class="number" name="number">
                        <option value="" selected="" disabled>未選択</option>
                        @for($i = 1; $i < 9; $i++)
                            <option value="{{$i}}">{{$i}}人</option>
                            @endfor
                    </select>
                    <div class="form__error">
                        @error('number') {{ $message }} @enderror
                    </div>
                    <div class="reservation__list">
                        @foreach($reservations as $reservation)
                        <table class="table">
                            <tr class="table__row">
                                <td class="table__header top">Shop</td>
                                <td class="table__data top">{{$reservation->shop->name}}</td>
                            </tr>
                            <tr class="table__row">
                                <td class="table__header">Date</td>
                                <td class="table__data">{{$reservation->date}}</td>
                            </tr>
                            <tr class="table__row">
                                <td class="table__header">Time</td>
                                <td class="table__data">{{substr($reservation->time, 0, 5)}}</td>
                            </tr>
                            <tr class="table__row">
                                <td class="table__header under">Number</td>
                                <td class="table__data under">{{$reservation->number}}</td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
                <button class="reservation__button" type="submit">予約する</button>
            </form>
        </div>
    </div>
    <div class="under__wrapper">
        <h2 class="under-content__ttl">お客様の声</h2>
        @foreach($reviews as $review)
        <div class="review__wrapper">
            <div class="review__item">
                <span class="name">{{ $review->user->name }}</span>
            </div>
            <div class="review__item">
                @for($i=0; $i<$review->evaluation;$i++)
                    <span class="evaluation"></span>
                    @endfor
            </div>
            <div class="review__item">
                <span class="comment">{{ $review->comment }}</span>
            </div>
        </div>
        @endforeach
        <div class="add-review__wrapper">
            <h3>レビューを追加</h3>
            <form class="review__form" action="/detail/review" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$shop->id}}">
                <div class="review-form__item">
                    @for($i = 0; $i < 5; $i++)
                        <input id="review{{$i+1}}" type="radio" name="review{{$i}}"><label for="review{{$i+1}}">★</label>
                        @endfor
                </div>
                <div class="review-form__item">
                    <textarea class="form__comment" name="comment"></textarea>
                </div>
                <div class="review-form__error">
                    @error('comment') {{ $message }} @enderror
                </div>
                <div class="review-form__item">
                    <button class="review__button" type="submit">送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection