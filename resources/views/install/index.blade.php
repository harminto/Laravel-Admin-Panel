<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Master Laravel</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/fontawesome/css/all.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/components.css') }}">
</head>
<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <h1>Install Laravel</h1>
                @if (session('error'))
                    <div style="color: red;">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div style="color: green;">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('install.perform') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Database</label>
                                <input type="text" class="form-control" name="database" required>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Host</label>
                                <input type="text" class="form-control" name="host" value="127.0.0.1" required>
                            </div>        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Port</label>
                                <input type="text" class="form-control" name="port" value="3306" required>
                            </div>        
                        </div>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-icon icon-left btn-sm btn-danger" data-nprogress><i class="fas fa-save"></i>&nbsp;Proses</button>
                </form>
            </div>
        </section>
        
    </div>

    <script src="{{ asset('assets/backend/stisla/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/backend/stisla/js/custom.js') }}"></script>
</body>
</html>