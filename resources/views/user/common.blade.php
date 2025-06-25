<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @yield('description')
    <meta property="og:site_name" content="ビッキーことば塾">
    <meta property="og:title" content="ビッキーことば塾">
    <meta property="og:image" content="">
    {{-- サーチコンソールここから --}}
    <meta name="google-site-verification" content="gQkqjp1HDVjt2wJ91BNgxsdqcyvYqvAeWQbb88tU4jI" />
    {{-- サーチコンソールここまで --}}

    <script src="{{ asset('js/index.js') }}?v={{ filemtime(public_path('js/index.js')) }}" defer></script>
    <script>
        window.csrfToken = '{{ csrf_token() }}';
    </script>

    <!-- @yield('title') -->

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

    <!-- @yield('pageCss') -->
</head>

<body>
   <div id="index"></div>
</body>

</html>
