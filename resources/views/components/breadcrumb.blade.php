<nav id="breadcrumb">
    <ul itemscope="" itemtype="https://schema.org/BreadcrumbList">

        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
            <a itemtype="https://schema.org/Thing" itemprop="item" href="https://bicky.herokuapp.com/">
                <span itemprop="name">{{ $item }}</span>
            </a>
            <meta itemprop="position" content="1">
        </li>
        
        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
            <a itemtype="https://schema.org/Thing" itemprop="item" href="{{ $url }}">
                <span itemprop="name">{{ $item2 }}</span>
            </a>
            <meta itemprop="position" content="2">
        </li>
        
    </ul>
</nav>