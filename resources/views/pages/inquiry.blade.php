@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="ビッキーことば塾では毎週、訓練中に評価した内容を文書にしてお渡ししております。評価書作成代も含めての料金になります。平日・休日でご利用可能です。料金は、平日・休日で異なります。">
@endsection

@section('title')
    <title>お問い合わせ | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/fee.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="お問い合わせ" url="https://bicky.herokuapp.com/inquiry" />
            <h1 class="main-title">お問い合わせ</h1>

            <p class="mb-4">
                お問い合わせは以下メールアドレスまでお願いいたします。<br>
                <a href="mailto:hattatsushien0724@gmail.com">hattatsushien0724@gmail.com</a>
            </p>
        </div>
    </div>
@endsection
