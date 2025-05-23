<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PDF</title>
        <style>
            @font-face{
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src:url('{{ storage_path('fonts/ipag.ttf')}}');
            }
            body {
                font-family: ipag;
            }

            p {
                margin: 0;
            }

            .container {
                margin: auto;
            }

            .title {
                font-size: 2rem;
                margin-top: 4rem;
                text-align: center;
            }

            .name {
                margin-top: 4rem;
            }

            .text-center {
                text-align: center;
            }

            .bold {
                font-weight: bold
            }

            .receipt {
                background-color: #e0ffff;
                border: 1px solid black ;
                margin: 0 auto;
                margin-top: 6rem;
                text-align: center;
                width: 60%;
            }

            .receipt__title { 
                padding: 1rem;
            }

            .receipt__fee {
                border-top: 1px solid black ;
                padding: 1rem;
            }

            .vendor-info {
                margin-top: 6rem !important;
            }

            .vendor-info p {
                text-align: right;
                margin-left: auto;
                margin-top: .4rem;
                width: 33%;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <p class="title">訓練利用料領収書（{{ date('Y年m月') }}）分</p>
            <p class="name">{{ $name }}　様</p>

            <div class="receipt" style="width: 100%;">
                <p class="receipt__title">金額</p>
                <p class="receipt__fee">¥{{ number_format($fee) }}</p>
            </div>

            <div class="vendor-info">
                <p>  <span class="vendor-info__content">{{ date('Y年m月d日', time()) }}</span></p>
                <p>    <span class="vendor-info__content">〒618-0015</p></span>
                <p>        <span class="vendor-info__content">大阪府三島郡島本町青葉1-7-6</p></span>
                <p>    <span class="vendor-info__content">ビッキーことば塾</p></span>
                <p>    <span class="vendor-info__content">常深夏子</p></span>
                <p>         <span class="vendor-info__content">090-7350-1929</p></span>
            </div>
        </div>
    </body>
</html>