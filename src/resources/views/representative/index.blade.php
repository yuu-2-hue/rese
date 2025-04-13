@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/index.css') }}" />
@endsection

@section('content')
<div class="representative__container">
    <h2 class="representative-name">{{$name}}さん</h2>
    <div class="button__wrapper">
        <a class="store__button" href="/representative/store">店舗追加</a>
    </div>
    @foreach($shops as $shop)
    <div class="representative__wrapper">
        <div class="nav">
            <div class="shop-name__wrapper">
                <p class="shop-name">{{$shop->name}}</p>
            </div>
            <div class="btn">
                <button class="mail__btn" id="mailButton{{$shop->id}}" onclick="isMailFormActive('{{$shop->id}}')">メール</button>
                <button class="reservation__btn" id="reservationButton{{$shop->id}}" onclick="isReservationActive('{{$shop->id}}')">予約</button>
                <button class="detail__btn" id="detailButton{{$shop->id}}" onclick="isDetailFormActive('{{$shop->id}}')">情報</button>
            </div>
        </div>

        <form id="detail{{$shop->id}}" class="update__form" action="/representative/update" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $shop->id }}">

            <label for="file__upload{{$shop->id}}" class="file__label">ファイルを選択</label>
            <input id="file__upload{{$shop->id}}" class="file" type="file" name="image" onchange="updateLabel(this, {{$shop->id}})">
            <span id="file__name{{$shop->id}}">{{ basename($shop->image) }}</span>
            <div class="form__error">
                @error('image') {{ $message }} @enderror
            </div>

            <input class="name" type="text" name="name" value="{{ old('name', $shop->name) }}" placeholder="店名">
            <div class="form__error">
                @error('name') {{ $message }} @enderror
            </div>

            <select class="area" name="area" id="">
                <option disabled selected>All Area</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ old('area', $shop->area->id)==$area->id ? 'selected' : '' }}>{{ $area->area }}</option>
                @endforeach
            </select>
            <div class="form__error">
                @error('area') {{ $message }} @enderror
            </div>

            <select class="genre" name="genre" id="">
                <option disabled selected>All Genre</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre', $shop->genre->id)==$genre->id ? 'selected' : '' }}>{{ $genre->genre }}</option>
                @endforeach
            </select>
            <div class="form__error">
                @error('genre') {{ $message }} @enderror
            </div>

            <textarea class="overview" name="overview" placeholder="店舗の概要を記入">{{$shop->overview}}</textarea>
            <div class="form__error">
                @error('overview') {{ $message }} @enderror
            </div>

            <div class="update__form--button">
                <button type="submit">登録</button>
            </div>
        </form>
        <form id="mail{{$shop->id}}" class="mail__form" action="/representative/send" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $shop->id }}">
            <input class="subject" type="text" name="subject" placeholder="件名">
            <textarea class="main-text" name="text" placeholder="本文"></textarea>
            <div class="update__form--button">
                <button type="submit">送信</button>
            </div>
        </form>
        <div id="reservation{{$shop->id}}" class="reservation__wrapper">
            <table class="table">
                <tr class="table__row">
                    <th>予約者</th>
                    <th>日付</th>
                    <th>時間</th>
                    <th>人数</th>
                </tr>
                @foreach($reservations as $reservation)
                @if($reservation->shop_id === $shop->id)
                <tr class="table__row">
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->date }}</td>
                    <td>{{ $reservation->time }}</td>
                    <td>{{ $reservation->number }}</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection

<script>
    function isDetailFormActive(number) {
        const elementDetailTrigger = document.getElementById('detailButton' + number);
        const elementMailTrigger = document.getElementById('mailButton' + number);
        const elementReservationTrigger = document.getElementById('reservationButton' + number);

        const elementDetailForm = document.getElementById('detail' + number);
        const elementMailForm = document.getElementById('mail' + number);
        const elementReservationForm = document.getElementById('reservation' + number);

        if (elementDetailTrigger.classList.contains('active') == false) {
            elementDetailTrigger.classList.add('active');
            elementMailTrigger.classList.remove('active');
            elementReservationTrigger.classList.remove('active');

            elementDetailForm.classList.add('active');
            elementMailForm.classList.remove('active');
            elementReservationForm.classList.remove('active');
        } else {
            elementDetailTrigger.classList.remove('active');
            elementDetailForm.classList.remove('active');
        }
    }

    function isMailFormActive(number) {
        const elementDetailTrigger = document.getElementById('detailButton' + number);
        const elementMailTrigger = document.getElementById('mailButton' + number);
        const elementReservationTrigger = document.getElementById('reservationButton' + number);

        const elementDetailForm = document.getElementById('detail' + number);
        const elementMailForm = document.getElementById('mail' + number);
        const elementReservationForm = document.getElementById('reservation' + number);

        if (elementMailTrigger.classList.contains('active') == false) {
            elementMailTrigger.classList.add('active');
            elementDetailTrigger.classList.remove('active');
            elementReservationTrigger.classList.remove('active');

            elementMailForm.classList.add('active');
            elementDetailForm.classList.remove('active');
            elementReservationForm.classList.remove('active');
        } else {
            elementMailTrigger.classList.remove('active');
            elementMailForm.classList.remove('active');
        }
    }

    function isReservationActive(number) {
        const elementDetailTrigger = document.getElementById('detailButton' + number);
        const elementMailTrigger = document.getElementById('mailButton' + number);
        const elementReservationTrigger = document.getElementById('reservationButton' + number);

        const elementDetailForm = document.getElementById('detail' + number);
        const elementMailForm = document.getElementById('mail' + number);
        const elementReservationForm = document.getElementById('reservation' + number);

        if (elementReservationTrigger.classList.contains('active') == false) {
            elementReservationTrigger.classList.add('active');
            elementDetailTrigger.classList.remove('active');
            elementMailTrigger.classList.remove('active');

            elementReservationForm.classList.add('active');
            elementMailForm.classList.remove('active');
            elementDetailForm.classList.remove('active');
        } else {
            elementReservationTrigger.classList.remove('active');
            elementReservationForm.classList.remove('active');
        }
    }

    function updateLabel(input, shopId) {
        const fileNameElement = document.getElementById("file__name" + shopId);
        if (input.files.length > 0) {
            fileNameElement.textContent = input.files[0].name;
        } else {
            fileNameElement.textContent = "選択されていません";
        }
    }
</script>