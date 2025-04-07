@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}" />
@endsection

@section('content')
<div class="admin__container">
    <h2 class="page__ttl">店舗代表者一覧</h2>
    <div class="button__wrapper">
        <a class="store__button" href="/admin/store">代表者追加</a>
    </div>
    <table class="table">
        <tr class="table__row">
            <th>代表者名</th>
            <th>メールアドレス</th>
        </tr>
        @foreach($representatives as $representative)
        <tr class="table__row">
            <td>{{ $representative->name }}</td>
            <td>{{ $representative->email }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection