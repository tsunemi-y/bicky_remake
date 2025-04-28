@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="言語聴覚士・保育士・高校教諭など複数の免許を持った指導員が、言葉の遅れ、発達障害、構音障害などのお子様の訓練を行います。">
@endsection

@section('title')
    <title>指導員紹介 | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/introduction.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="指導員紹介" url="https://bicky.herokuapp.com/introduction" />
            <h1 class="main-title">指導員紹介</h1>
            <div class="text-center">
                <img src="{{ asset('img/staff.png') }}" alt="言語聴覚士・保育士・高等学校教諭の免許を持った指導員です。">
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

            <section>
                <h2>経歴</h2>
                
                <p class="mb-2">
                    小学校から始めた剣道を20年間続ける。<br>
                </p>

                <p class="mb-2">
                    中学校では近畿大会、<br>
                    高等学校では全国大会、<br>
                    大学では都道府県大会の兵庫県代表で出場
                </p>
                    
                <p>
                    中学校、高等学校、大学で剣道部主将を務める。<br>
                    教員退職後は、訪問介護事業の開設に携わる。<br>
                    児童発達支援事業で言語聴覚士としてことばの訓練及び療育を行う。<br>
                    現在、民間事業ビッキーことば塾でことばの訓練を行う。
                </p>    
            </section>

        </div>
    </div>
@endsection