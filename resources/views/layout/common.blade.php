<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="JR島本駅から徒歩5分!!言語聴覚士・保育士・高校教諭など複数の免許を持った指導員が訓練を行います。言葉の遅れ、発達障害、構音障害などのお子様の訓練を行います。">
        <meta property="og:site_name" content="ビッキーことば塾">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">   
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <title>ビッキーことば塾</title>
        @yield('pageCss')
    </head>
    <body>
        @yield('header')
        <div class="container">
            <!-- コンテンツ -->
            @yield('content')
        </div>  
        {{-- <footer class="align-middle footer mt-4">
            <p class="footer__content">Copyright (c) bicky All Rights Reserved.</p>
        </footer> --}}
        @yield('footer')
        @yield('pageJs')
        <script src="{{ asset('js/header.js') }}"></script>  
        <script src="{{ asset('js/top.js') }}"></script>  
    </body>
</html>