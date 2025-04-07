@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/representative/store.css') }}" />
@endsection

@section('content')
<div class="store__container">
    <h2 class="page__ttl">店舗追加</h2>
    <form class="form" action="/representative/store/create" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__item">
            <label for="file__upload" class="file__label">ファイルを選択</label>
            <input id="file__upload" class="file" type="file" name="image" onchange="updateLabel(this)">
            <span id="file__name">選択されてません</span>
            <div class="file-form__error">
                @error('image') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <input class="name" type="text" name="name" value="{{ old('name') }}" placeholder="店名">
            <div class="form__error">
                @error('name') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <select class="area" name="area" id="">
                <option disabled selected>All Area</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ old('area')==$area->id ? 'selected' : '' }}>{{ $area->area }}</option>
                @endforeach
            </select>
            <div class="form__error">
                @error('area') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <select class="genre" name="genre" id="">
                <option disabled selected>All Genre</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre')==$genre->id ? 'selected' : '' }}>{{ $genre->genre }}</option>
                @endforeach
            </select>
            <div class="form__error">
                @error('genre') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <textarea class="overview" name="overview" placeholder="店舗の概要を記入"></textarea>
            <div class="form__error">
                @error('overview') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__button">
            <button type="submit">登録</button>
        </div>
    </form>
</div>
@endsection

<script>
    function updateLabel(input) {
        if (input.files.length > 0) {
            document.getElementById("file__name").textContent = input.files[0].name;
        } else {
            document.getElementById("file__name").textContent = "選択されていません";
        }
    }
</script>