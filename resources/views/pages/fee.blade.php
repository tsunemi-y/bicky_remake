@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="ビッキーことば塾では毎週、訓練中に評価した内容を文書にしてお渡ししております。評価書作成代も含めての料金になります。平日・休日でご利用可能です。料金は、平日・休日で異なります。">
@endsection

@section('title')
    <title>料金・プラン | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/fee.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="料金・プラン" url="https://bicky.herokuapp.com/fee" />
            <h1 class="main-title">料金・プラン</h1>

            <p class="mb-4">
                ビッキーことば塾では、訓練中に評価した内容を文書にしてお渡ししております。<br>
                下記記載の料金は、評価書作成代も含めての料金になります。<br>
                ご利用に年齢制限はございません。<br>
                大人の方でもご利用できます。
            </p>
            
            <section class="mb-4">
                <h2>通常プラン（現在は土日コースのみ）</h2>
                <section class="mb-4">
                    <p>
                        中学生未満の場合は、通常利用と兄弟同時利用の2種類があります。<br>
                        通常利用は、60分利用と同じ料金です。<br>
                        兄弟同時利用は、90分利用と同じ料金です。
                    </p>
                    <table border="1" class="text-center mb-2 mt-2" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="bg-white" width="20%"></th>
                                <th class="font-weight-bold">お一人（60分）</th>
                                <th class="font-weight-bold">兄弟児同時利用（90分）</th>
                                <th class="font-weight-bold">兄弟児別々利用</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr class="table-height">
                                <th style="background-color: #fdffe5;">料金</th>
                                <th>8,800円</th>
                                <th>13,200円（お一人6,600円）</th>
                                <th>8,800円×人数（二名だと120分）</th>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        ☆兄弟児様で同時ご利用頂ける場合に限り、1回90分で2,200円の割引きが適用されます。<br>
                        なお、お一人60分で兄弟児様別々（完全個別）でご利用される場合は、通常の8,800円×人数の料金になります。
                    </p>
                </section>

                <section class="mb-4">
                <h2>中学生限定特別プラン</h2>
                <section class="mb-4">
                    <table border="1" class="text-center mb-2 mt-2" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="bg-white" width="20%"></th>
                                <th class="font-weight-bold">通常コース（60分）</th>
                                <th class="font-weight-bold">特進コース（90分）</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr class="table-height">
                                <th style="background-color: #fdffe5;">料金</th>
                                <th>8,800円</th>
                                <th>13,200円</th>
                            </tr>
                        </tbody>
                    </table>

                    <p>
                        通常コースは、60分（30分課題学習+10分コミュニケーショントレーニング+20分保護者からのヒアリング）<br>
                        特進コースは、90分（50分課題学習+10分コミュニケーショントレーニング+30分保護者からのヒアリング）<br>
                        となります。<br>
                        ☆ご予約の際に、どちらかお選び下さい。<br>
                        ※現在、システムが更新されていない状況ですので、LINEでスタッフに希望日とお時間をお知らせ頂いてから、ご予約をお願い致します。<br>
                        ご予約時間によっては、90分お取りできない場合もございますので、ご予約希望日時とコースの連絡をLINEにて、お願い致します。<br>
                        システムの更新は6月下旬予定です。
                    </p>
                </section>

                <section class="mb-4">
                <h2>お支払い方法について</h2>
                <section class="mb-4">
                    <p>
                        現在は、現金のみで受け付けております。<br>
                        おつりのご用意ができません（スムーズに次の方へ引き継ぐためです）<br>
                        大変お手数をおかけして申し訳ございませんが、あらかじめご用意をお願い致します。
                    </p>
                </section>

            </section>

        </div>
    </div>
@endsection
