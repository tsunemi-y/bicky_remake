@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/fee.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title">料金・プラン</h1>
            <p class="mb-4">
                平日と休日によって料金・時間が異なります。<br>
                違いについては下記をご覧ください。
            </p>
            
            {{-- 平日予約 --}}
            <section class="mb-4">
                <h2>平日の料金・プラン</h2>

                <section class="mb-4">
                    <h3>1.予約方法</h3>
                    <p>下記手順でご予約ください。<br>
                        1.本ページ上部のメニューから予約ページへ移動<br>
                        2.日時を指定<br>
                        3.初回予約か2回目以降の予約かを選択<br>
                        4.必要情報をフォームに入力<br>
                        ※初回予約時は、氏名・メールアドレス以外も入力して頂く必要がございます。
                    </p>
                </section>

                <section class="mb-4">
                    <h3>2.料金</h3>
                    <p class="mb-2">
                        月の訓練回数に応じた月謝制になります。<br>
                        月によって料金が異なりますのでご注意くださいませ。<br>
                        一回あたりの利用料は、4,400円（税込み）になります。
                    <p>
                    <table border="1" class="text-center mb-2" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="font-weight-bold">月4回時</th>
                                <th class="font-weight-bold">月5回時</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr class="table-height">
                                <th>17,600円</th>
                                <th>22,000円</th>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        ■返金について<br>
                        ※こちらの都合でお休みになった日はご利用料を返金対応させて頂きます。<br>
                        ご利用者様都合でお休みされる場合は返金や減額ができませんので、予めご了承くださいますようお願い申しあげます。<br class="mb-2">
                        <b>■振替について</b><br>
                        ご希望の方は、スタッフにご相談ください。<br>
                        ・月謝の支払いは前月の最終日までに現金にてお支払いいただきます。<br>
                        ・振込希望の方はご相談ください。（振込手数料はご利用者様負担）<br>
                    </p>
                </section>

                <section>
                    <h3>3.ご予約可能日時</h3>
                    <table border="1" class="text-center" width="100%">
                        <thead>
                            <tr class="table-header">
                                <th class="font-weight-bold" width="60">曜日</th>
                                <th class="font-weight-bold" width="200">時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservationTimes as $rsvTime)
                                
                                <tr class="table-height">
                                    <th>月～金</th>
                                    <th>{{ $rsvTime['reservation_time_from']. '~'. $rsvTime['reservation_time_to']. '（50分）'}}</th>
                                </tr>
        
                            @endforeach
                        </tbody>
                    </table>
                </section>

            </section>
           
            {{-- 休日予約 --}}
            <section>
                <h2>休日の料金・プラン</h2>

                <section class="mb-4">
                    <h3>1.予約方法</h3>
                    <p>
                        休日予約は月1回のみご利用可能です。<br>
                        ご希望のご利用者様は下記メールアドレスまでご連絡ください<br>
                        <a href="mailto:hattatsushien@gmail.com">hattatsushien@gmail.com</a>
                    </p>
                </section>

                <section class="mb-4">
                    <h3>2.料金</h3>
                    <p class="mb-2">
                        一回あたりの利用料は、6,600円（税込み）になります。
                    <p>
                </section>

            </section>

        </div>
    </div>
@endsection
