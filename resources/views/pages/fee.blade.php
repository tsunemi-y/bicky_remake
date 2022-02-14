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
                ビッキーことば塾では、訓練中に評価した内容を文書にしてお渡ししております。
                下記記載の料金は、評価書作成代も含めての料金になります。
            </p>
            
            {{-- 料金・プラン --}}
            <section class="mb-4">
                <h2>料金・プラン</h2>
                <section class="mb-4">
                    <p class="mb-2">
                        訓練回数は月1回または2回のどちらかをご選択いただけます。<br>
                        月2回の場合は、月1回の倍の料金になります。<br>
                        月2回の場合は、来所での訓練が月2回（隔週）、評価表が2回分になります。<br>
                        LINEでの相談は、2回以上で4回までご利用可能です。
                    <p>
                    <table border="1" class="text-center mb-2" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="bg-white"></th>
                                <th class="font-weight-bold">平日利用</th>
                                <th class="font-weight-bold">休日利用</th>
                                <th class="font-weight-bold">兄弟同時利用</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr class="table-height">
                                <th style="background-color: #fdffe5;">月1回</th>
                                <th>7,700円</th>
                                <th>8,800円</th>
                                <th>13,200円（6,600円/人）</th>
                            </tr>
                            <tr class="table-height">
                                <th style="background-color: #fdffe5;">月2回</th>
                                <th>15,400円</th>
                                <th>17,600円</th>
                                <th>26,400円（13,200円/人）</th>
                            </tr>
                        </tbody>
                    </table>

                    <p class="mb-2">
                        <span class="font-weight-bold">■お支払い方法について</span><br>
                        現金のみ受け付けております。
                        来所時にお支払いをよろしくお願い致します。
                    </p>

                </section>

            </section>

        </div>
    </div>
@endsection
