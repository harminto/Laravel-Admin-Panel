<header class="header">
    <a href="{{ route('beranda') }}" class="logo">
        <img src="{{ asset('assets/landing/images/logo.png') }}" />
        <span>e-</span>Event
    </a>

    <nav class="navbar">
        <a href="{{ route('beranda') }}"> home</a>
        <a href="{{ route('beranda') }}#timeline">Timeline</a>
        <a href="{{ route('beranda') }}#artikel">News</a>
        {{-- <a href="{{ route('beranda') }}#gallery">Galeri Prodi</a> --}}
        <a href="{{ route('beranda') }}#price">Unggulan</a>
        <a href="{{ route('beranda') }}#review">Sponsorship</a>
        <a href="{{ route('beranda') }}#contact">Hubungi Kami</a>
        <a href="{{ route('login') }}" target="_blank"><i class="fas fa-sign-in-alt"></i> Login</a>
    </nav>

    <div id="menu-bars" class="fas fa-bars"></div>

</header>