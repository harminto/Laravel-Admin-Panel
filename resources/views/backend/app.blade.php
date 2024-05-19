<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard &mdash; {{ \App\Models\AppSetting::where('setting_key', 'short_name')->value('setting_value') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/backend/stisla/img/example-image.jpg') }}">
    

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/fontawesome/css/all.min.css') }}">

      <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/izitoast/css/iziToast.min.css') }}">
    
    <!-- Nprogress -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/nprogress/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/toastr/toastr.css') }}">
    
    <!-- CSS Libraries -->
    @yield('custom-css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/components.css') }}">
    
    </head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('backend.partials.navbar')

            <div class="main-sidebar sidebar-style-2">
                @include('backend.partials.sidebar')
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    @yield('breadcrumb')
                </div>
                <div class="section-body">
                    @yield('content')
                </div>
            </section>
        </div>
        
        <footer class="main-footer">
            @include('backend.partials.footer')
        </footer>
    </div>


    @include('backend.partials.script')

    @yield('custom-js')

    
@stack('scripts')
</body>

</html>