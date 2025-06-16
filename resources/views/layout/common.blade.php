<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('description')
    <meta property="og:site_name" content="ビッキーことば塾">
    <meta property="og:title" content="ビッキーことば塾">
    <meta property="og:image" content="">
    {{-- サーチコンソールここから --}}
    <meta name="google-site-verification" content="gQkqjp1HDVjt2wJ91BNgxsdqcyvYqvAeWQbb88tU4jI" />
    {{-- サーチコンソールここまで --}}

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
        integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    {{-- moment.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/ja.js"></script>
    {{-- ログロケット --}}
    <script src="https://cdn.lr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
    <script>
        window.LogRocket && window.LogRocket.init('tjnhom/bickey');
    </script>

    @yield('title')

    <!-- グーグルアナリティクスここから -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GJKN48921H"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-GJKN48921H');
    </script>
    <!-- グーグルアナリティクスここまで -->

    @yield('pageCss')
</head>

<body>
    @yield('header')
    @yield('heroImg')

    <div class="container">
        <!-- コンテンツ -->
        @yield('content')
    </div>

    @yield('footer')
    @yield('pageJs')
    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>
