@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection
@section('content')
@if (session('successReservation'))
        <div class="alert alert-success">
            <p>{!! session('successReservation') !!}</p>
        </div>   
    @endif

    @if (session('successCancel'))
        <div class="alert alert-success">
            <p>{{ session('successCancel') }}</p>
        </div>   
    @endif
    
<div class="row animation">
    <div class="col-md-6 mb-4">
        <div class="room-img text-center">
            <img src="{{ asset('img/playroom.jpg') }}" alt="プレイルーム">
        </div>
    </div>
    <div class="col-md-6">
        <br>
        ことばの訓練を通して、自己肯定感を養い、<br>
        社会で自分らしく生きていくスキルを身につけます。<br>
        1歳～小学校2年生頃までの児童が対象です。<br>
        親子指導や集団指導もあります。<br>
        <br>
        <b>■対象</b><br>
        障がいの有無は問いません。<br>
        コミュニケーション面や学習面など、<br>
        様々なお悩みに対応しています。<br>
    </div>
</div>

<script>
    $(function () {
    ScrollReveal().reveal('.animation', {
        delay: 500,
        duration: 2000,
    });
});
</script>
@endsection