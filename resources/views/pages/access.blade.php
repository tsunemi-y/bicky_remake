@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="JR島本駅から徒歩5分、阪急水無瀬駅から徒歩9分の場所にあります。">
@endsection

@section('title')
    <title>アクセス | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/access.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="アクセス" url="https://bicky.herokuapp.com/access" />
            <h1 class="main-title">アクセス</h1>

            <section class="mb-4">
                <h2>住所</h2>
                <p class="mb-3">
                    〒618-0015<br>
                    大阪府三島郡島本町青葉1-7-6
                </p>
            </section>

            <section class="mb-4">
                <h2>電車でお越しの場合</h2>
                <p class="mb-3">
                    JR島本駅から徒歩5分<br>
                    阪急水無瀬駅から徒歩9分<br>
                </p>
            </section>

            <section class="mb-4">
                <h2>お車でお越しの場合</h2>
                <p>
                    1台分の乗用車駐車スペースがありますが、幅が狭いため、ご注意ください。<br>
                    ご利用される方は、事前にお声がけいただきますようお願い致します。
                </p>
            </section>

            <section>
                <h2>マップ</h2>
                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3273.099934029152!2d135.66152621458036!3d34.8788367811657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60010344762683d9%3A0xfdbc7a464365b42c!2z44CSNjE4LTAwMTUg5aSn6Ziq5bqc5LiJ5bO26YOh5bO25pys55S66Z2S6JGJ77yR5LiB55uu77yX4oiS77yW!5e0!3m2!1sja!2sjp!4v1630594432901!5m2!1sja!2sjp"
                aria-hidden="false"></iframe>
            </section>
        </div>
    </div>
@endsection