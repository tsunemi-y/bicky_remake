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
                <h2>中学生未満</h2>
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
                                <th class="font-weight-bold" width="40%">通常利用（60分）</th>
                                <th class="font-weight-bold">兄弟同時利用（90分）</th>
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
                </section>

                <section class="mb-4">
                <h2>中学生</h2>
                <section class="mb-4">
                    <p>
                        中学生の場合は、60分利用と90分利用の2種類があります。<br>
                        60分利用は、通常利用と同じ料金です。<br>
                        90分利用は、兄弟同時利用と同じ料金です。
                    </p>
                    <table border="1" class="text-center mb-2 mt-2" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="bg-white" width="20%"></th>
                                <th class="font-weight-bold" width="40%">60分利用</th>
                                <th class="font-weight-bold">90分利用</th>
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
