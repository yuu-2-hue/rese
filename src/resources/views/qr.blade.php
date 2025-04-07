@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qr.css') }}" />
@endsection

@section('content')
<div class="qr__container">
    <h2>QRコード</h2>
    {!! $qrCode !!}
</div>
@endsection