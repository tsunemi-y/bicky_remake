@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/introduction.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title">指導員紹介</h1>
            <div class="text-center">
                <img src="{{ asset('img/staff.png') }}" alt="">
            </div>

            <section class="mb-4">
                <h2>プロフィール</h2>
                <p>
                    <span class="font-weight-bold">【氏名】</span><br>
                    <span class="d-inline-block mb-1">常深夏子（つねみなつこ）</span><br>
                    <span class="font-weight-bold">【免許・資格】</span><br>
                    <span class="d-inline-block mb-1">言語聴覚士、保育士、高等学校教諭、介護福祉士</span><br>
                    <span class="font-weight-bold">【学歴】</span><br>
                    <span class="d-inline-block mb-1">関西学院大学卒業</span>
                </p>    
            </section>

            <section class="mb-4">
                <h2>経歴</h2>
                <p>
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
            </section>

        </div>
    </div>
@endsection