<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ isset($ogTitle) && !empty($ogTitle) ? $ogTitle : 'E-Event FST UNISNU Jepara: Menyelenggarakan Acara Saintek Expo dan Kompetisi Teknologi' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('manifest/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('manifest/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('manifest/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('manifest/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('manifest/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('manifest/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('manifest/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('manifest/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('manifest/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('manifest/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('manifest/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('manifest/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('manifest/favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('manifest/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- mulai penanganan SEO -->
    <meta property="og:title" content="{{ isset($ogTitle) && !empty($ogTitle) ? $ogTitle : 'E-Event FST UNISNU Jepara: Menyelenggarakan Acara Saintek Expo dan Kompetisi Teknologi' }}">
    <meta property="og:description" content="{{ isset($ogDescription) && !empty($ogDescription) ? $ogDescription : 'Jelajahi serangkaian acara Saintek Expo yang menghadirkan workshop, seminar, dan kompetisi menarik seputar sains dan teknologi di FST UNISNU Jepara.' }}">
    <script>
        var imgElement = document.querySelector('img');

        if (imgElement) {
            var imgSrc = imgElement.getAttribute('src');
            if (imgSrc) {
                var metaTag = document.createElement('meta');
                metaTag.setAttribute('property', 'og:image');
                metaTag.setAttribute('content', imgSrc);
                document.head.appendChild(metaTag);
            }
        }
        // Dapatkan URL saat ini
        let currentPageUrl = window.location.href;

        // Jika ada bagian anchor (#), hapus bagian tersebut
        if (currentPageUrl.includes('#')) {
            currentPageUrl = currentPageUrl.split('#')[0];
        }

        // Gunakan currentPageUrl dalam tag meta Open Graph
        document.querySelector('meta[property="og:url"]').setAttribute('content', currentPageUrl);
    </script>
    <!-- selesai penanganan SEO -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    

    <!-- custom css file -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<!-- Header section start -->
@include('landing.partials.header')
<!-- Header section end -->
    


@yield('konten')

<!-- contact section start -->
@yield('kontak')
<!-- contact section end -->

<!-- footer section start -->
@include('landing.partials.footer')
<!-- footer section end -->

<!-- theme toggler  -->
<div class="theme-toggler">
    <div class="toggle-btn">
        <i class="fas fa-cog"></i>
    </div>

    <h3>Pilih Warna Tema!</h3>

    <div class="buttons">
        <div class="theme-btn" style="background: #ccff33"></div>
        <div class="theme-btn" style="background: #d35400"></div>
        <div class="theme-btn" style="background: #f39c12"></div>
        <div class="theme-btn" style="background: #1abc9c"></div>
        <div class="theme-btn" style="background: #3498db"></div>
        <div class="theme-btn" style="background: #9b59b6"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- custom js file -->
<script src="{{ asset('assets/landing/js/script.js') }}"></script>

</body>
</html>