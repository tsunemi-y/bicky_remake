@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="ビッキーことば塾では、得意なことを伸ばして苦手なことにもチャレンジできる強い心と安定した心を養い人間力（社会で生きていくための力）を鍛えます。お子様の性格や特性の理解、発達段階に応じた訓練計画を立案します。">
@endsection

@section('title')
    <title>訓練 | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練 </title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/overview.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="訓練内容" url="https://bicky.herokuapp.com/overview" />
            <h1 class="main-title">訓練内容</h1>

            <p class="mb-4">
                LINEやメールで状況確認を致します。<br>
                直接訓練後の経過を週に1度観察し、次回の訓練時までに環境の調整を行っていきます。<br>
                来所での訓練時の様子から評価表を作成致します。<br>
                評価表の作成には1週間前後かかります。<br>
                作成した文書はメール（PDF）にて送信致します。<br>
                遠方からのご利用の方やコロナ渦ということを考慮致しまして、
                安全に訓練を受けて頂きたいと考えています。<br>
            </p>

            <section class="mb-4">
                <h2>訓練詳細</h2>
                <table class="sp-table" border="1">

                    <tr><th>訓練曜日</th></tr>
                    <tr><td>月~日</td></tr>
                  
                    <tr><th>訓練回数</th></tr>
                    <tr><td>月1回または2回</td></tr>

                    <tr><th>訓練時間</th></tr>
                    <tr>
                        <td>
                            1時間<br>
                            ※兄弟利用の場合は1時間半
                        </td>
                    </tr>

                    <tr><th>開所時間</th></tr>
                    <tr><td>10時~14時</td></tr>

                    <tr><th>LINE相談</th></tr>
                    <tr>
                        <td>
                            お子様の1週間のご様子を報告していただきます<br/>
                            動画を添付してご送信ください<br/>
                            指導員が返答致します
                        </td>
                    </tr>

                    <tr><th>LINE相談回数</th></tr>
                    <tr>
                        <td>
                            週に1回<br/>
                            ※月の訓練回数によって変動あり
                        </td>
                    </tr>
                  
                </table>
            </section>

            <section>
                <h2>予約方法</h2>
                <p>
                    本ホームページの予約画面から空いている日時をクリックしてご予約を取って頂きます。<br>
                    当日キャンセルは、お電話でのご連絡をお願い致します。<br>
                </p>
            </section>
            
        </div>
    </div>
@endsection