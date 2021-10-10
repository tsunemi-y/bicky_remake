@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/fee.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title text-center">料金・プラン</h1>
            <p>■開設日は<b>水曜</b>と<b>木曜</b>のみです</p>
            <br>
            <p><b>■言語発達指導及びペアレント指導</b></p>
            <table border="1" class="text-center" width="100%">
                <thead>
                    <tr class="table-header">
                        <th width="200">時間</th>
                        <th width="60">曜日</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-height">
                        <th>11：00～11：40（40分）</th>
                        <th>水・木</th>
                    </tr>
                    <tr class="table-height">
                        <th>13：00～13：40（40分）</th>
                        <th>水・木</th>
                    </tr>
                    <tr class="table-height">
                        <th>14：00～14：40（40分）</th>
                        <th>水・木</th>
                    </tr>
                    <tr class="table-height">
                        <th>15：00～15：40（40分）</th>
                        <th>水・木</th>
                    </tr>
                    <tr class="table-height">
                        <th>16：00～16：40（40分）</th>
                        <th>水・木</th>
                    </tr>
                </tbody>
            </table>
            <br>
            <p>
                <b>■毎回ご持参いただいている利用料について</b><br>
                来年度からは、つきの回数に応じた月謝制になります。<br>
                ◆例<br>
                つき4回：　4,400円×4回＝17,600円<br>
                つき5回：　4,400円×5回＝22,000円<br>
                <br>
                こちらの都合でお休みになった日はご利用料を返金対応させて頂きます。<br>
                ご利用者様都合でお休みされる場合は返金や減額ができませんので、予めご了承くださいますようお願い申しあげます。<br>
                <br>
                <b>■振替について</b><br>
                ご希望の方は、10：00～10：40の枠で振替えをさせていただきます。<br>
                ◆月謝の支払いは前月の最終日までに現金にてお支払いいただきます。<br>
                ◆振込希望の方はご相談ください。（振込手数料はご利用者様負担）<br>
            </p>
        </div>
    </div>
@endsection
