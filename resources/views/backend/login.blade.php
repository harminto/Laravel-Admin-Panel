<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
  <!-- Nprogress -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/nprogress/nprogress.css') }}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{{ asset('assets/css/custom-style.css') }}">

</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('login') }}"><b>Admin</b>LTE</a>
        </div>
		
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <div id="flash-message" class="alert alert-danger" style="display: none;"></div>

            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group has-feedback">
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                        <button class="btn btn-primary btn-block btn-flat nprogress" onclick="loginUser(event)">&nbsp;{{ __('Login') }}</button>
                    </div>
                    <!-- /.col -->
                </div>						
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>

<!-- jQuery 3 -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Nprogress -->
<script src="{{ asset('assets/plugins/nprogress/nprogress.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- iCheck -->
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
            toastr.success(response.message);
            // Pengalihan ke halaman dashboard setelah login berhasil
            window.location.href = response.redirect;
        } else {
            toastr.error('Login GAGAL, Email atau password salah');
        }
    };

    xhr.onerror = function() {
        toastr.error('An error occurred during the login process.');
    };

    var formData = new FormData(form);
    xhr.send(formData);
}

</script>

</body>
</html>
