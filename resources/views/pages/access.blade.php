@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/access.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title text-center">アクセス</h1>
            <p>
                <b>■住所</b><br>
                〒618-0015<br>
                大阪府三島郡島本町青葉1-7-6<br>
                <br>
                <b>■最寄駅からの所要時間・経路</b><br>
                JR島本駅から徒歩5分<br>
                阪急水無瀬駅から徒歩9分<br>
                <br>
            </p>
            <div>
              <b>■マップ</b><br>
                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3273.099934029152!2d135.66152621458036!3d34.8788367811657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60010344762683d9%3A0xfdbc7a464365b42c!2z44CSNjE4LTAwMTUg5aSn6Ziq5bqc5LiJ5bO26YOh5bO25pys55S66Z2S6JGJ77yR5LiB55uu77yX4oiS77yW!5e0!3m2!1sja!2sjp!4v1630594432901!5m2!1sja!2sjp"
                aria-hidden="false"></iframe>
            </div>
    </div>
@endsection