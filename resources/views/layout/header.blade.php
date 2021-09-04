@section('header')

{{-- メニュー中身 --}}
<div class="align-items-center d-flex flex-column justify-content-center menu-inner position-fixed sp-header" id="js-menu-inner">
    <div><a href="{{ route("greeting")}}" class="menu-inner__link">ご挨拶</a></div>
    <div><a href="{{ route("fee") }}" class="menu-inner__link">料金・プラン</a></div>
    <div><a href="{{ route("reservation") }}" class="menu-inner__link">予約</a></div>
    <div><a href="{{ route("introduction") }}" class="menu-inner__link">指導員紹介</a></div>
    <div><a href="{{ route("access") }}" class="menu-inner__link">アクセス</a></div>
</div>

<header class="header mb-4">
    <div class="align-items-center container d-flex header__item">
        <h1 class="header-title mr-2"><a href="{{ route("top")}}">ビッキーことば塾</a></h1>
        <div class="header-phone"><i class="fas fa-mobile-alt mr-1"></i><a href="tel:06‐6777‐9427">06-6777-9427</a></div>
        {{-- pcメニュー　ここから --}}
        <div class="pc-header">
            <div class=""><a href="{{ route("greeting")}}" class="pc-header__item">ご挨拶</a></div>
            <div class=""><a href="{{ route("fee") }}" class="pc-header__item">料金・プラン</a></div>
            <div class=""><a href="{{ route("reservation") }}" class="pc-header__item">予約</a></div>
            <div class=""><a href="{{ route("introduction") }}" class="pc-header__item">指導員紹介</a></div>
            <div class=""><a href="{{ route("access") }}" class="pc-header__item">アクセス</a></div>
        </div>
        {{-- pcメニュー　ここまで --}}

        {{-- ハンバーガーメニュー　ここから --}}
        <div class="menu sp-header" id="js-menu">
            <span class="menu__top" id="js-menu-top"></span>
            <span class="menu__middle" id="js-menu-middle"></span>
            <span class="menu__bottom" id="js-menu-bottom"></span>
        </div>
        {{-- ハンバーガーメニュー　ここまで --}} 
    </div>
</header>

@endsection

@section('footer')
    <footer class="align-middle footer">
        <p class="footer__content">Copyright (c) bicky All Rights Reserved.</p>
    </footer>
@endsection

