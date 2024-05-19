<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ $judul }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/backend/stisla/img/example-image.jpg') }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/izitoast/css/iziToast.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/components.css') }}">

</head>
<body>
    <div id="app">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset('assets/backend/stisla/img/example-image.jpg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>
                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                    Please fill in your email
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                    <div class="invalid-feedback">
                                        please fill in your password
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-lg btn-block" tabindex="4" onclick="loginUser(event)">
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/backend/stisla/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/js/stisla.js') }}"></script>
  
    <!-- Template JS File -->
    <script src="{{ asset('assets/backend/stisla/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/js/custom.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/modules/izitoast/js/iziToast.min.js') }}"></script>
    <script>
    function loginUser(event) {
        event.preventDefault();

        var form = event.target.closest('form');
        var url = form.getAttribute('action');

        var xhr = new XMLHttpRequest();
        xhr.open(form.getAttribute('method'), url, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                window.location.href = response.redirect;
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'Login GAGAL, Email atau password salah',
                    position: 'topRight'
                });
            }
        };

        xhr.onerror = function() {
            iziToast.error({
                title: 'Error',
                message: 'Kesalahan pada sistem login',
                position: 'topRight'
            });
        };

        var formData = new FormData(form);
        xhr.send(formData);
    }
    </script>

    
</body>
</html>