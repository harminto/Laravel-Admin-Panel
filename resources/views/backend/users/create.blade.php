@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/custom.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/select2/dist/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
<h1>Kelola Data Pengguna</h1>
<div class="section-header-breadcrumb">
<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Setting</a></div>
<div class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h4>Tambah Pengguna</h4>
                <div class="card-header-action">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">
                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="usersForm" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <fieldset class="form-group custom-fieldset">
                        <legend>Informasi Pengguna</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="roles">Roles</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required style="width: 100%;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    

                    <button type="submit" id="submitBtn" class="btn btn-icon icon-left btn-sm btn-danger" data-nprogress><i class="fas fa-save"></i>&nbsp;Simpan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-icon icon-left btn-sm btn-dark" data-nprogress><i class="fas fa-retweet"></i>&nbsp;Batal</a>
        
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<!-- Select2 -->
<script src="{{ asset('assets/backend/stisla/modules/select2/dist/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();
    
    // Menangkap event submit form
    $('#usersForm').submit(function(event) {
        event.preventDefault(); // Menghentikan form submit secara default

        var form = $(this);
        handleFormSubmit(
            form,
            function(response) {
                showSuccessToast(response.message);
                window.location.href = '{{ route("users.index") }}'; // Redirect ke halaman index roles
            },
            function(error) {
                showErrorToast(error); // Menampilkan pesan kesalahan yang diterima dari server
                console.log(error);
            }
        );
    });
});
</script>
@endsection
