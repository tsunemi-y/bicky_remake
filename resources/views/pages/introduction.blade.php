@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/introduction.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title text-center">指導員紹介</h1>
            <div class="text-center">
                <img src="{{ asset('img/staff.png') }}" alt="">
            </div>
            <br>
            <p>
                氏名　　　：　常深夏子（つねみなつこ）<br>
                免許・資格：　言語聴覚士、保育士、高等学校教諭、介護福祉士<br>
                学歴　　　：　関西学院大学卒業<br>
                <br>
                ■経歴<br>
                小学校から始めた剣道を20年間続ける。<br>
                <br>
                中学校では近畿大会、<br>
                高等学校では全国大会、<br>
                大学では都道府県大会の兵庫県代表で出場<br>
                <br>
                高等学校は剣道の名門校PL学園高等学校卒業。<br>
                中学校、高等学校、大学で剣道部主将を務める。<br>
                教員退職後は、訪問介護事業の開設に携わる。<br>
                児童発達支援事業で言語聴覚士としてことばの訓練及び療育を行う。<br>
                現在、民間事業ビッキーことば塾でことばの訓練を行う。
            </p>
        </div>
    </div>
@endsection