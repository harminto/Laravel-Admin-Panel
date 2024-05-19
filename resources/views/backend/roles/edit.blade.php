@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/custom.css') }}">
@endsection

@section('breadcrumb')
<h1>Kelola Data Pengguna</h1>
<div class="section-header-breadcrumb">
<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Setting</a></div>
<div class="breadcrumb-item"><a href="{{ route('roles.index') }}">Aturan</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h4>Ubah Aturan/Roles</h4>
                <div class="card-header-action">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary">
                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="rolesForm" action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <fieldset class="form-group custom-fieldset">
                        <legend>Item Aturan</legend>
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}">
                        </div>
                    </fieldset>
        
                    <button type="submit" class="btn btn-icon icon-left btn-sm btn-danger" data-nprogress><i class="fas fa-save"></i>&nbsp;Update</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-icon icon-left btn-sm btn-dark" data-nprogress><i class="fas fa-retweet"></i>&nbsp;Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')

<script>
$(document).ready(function() {

    // Menangkap event submit form
    $('#rolesForm').submit(function(event) {
        event.preventDefault(); // Menghentikan form submit secara default

        var form = $(this);
        handleFormUpdate(
            form,
            function(response) {
                // Berhasil mengupdate data, tambahkan kode yang ingin Anda lakukan setelahnya
                window.location.href = '{{ route("roles.index") }}'; // Redirect ke halaman index menus
                showSuccessToast(response.message);
            },
            function(error) {
                showErrorToast(error);
                console.log(error);
            }
        );
    });
});
</script>
@endsection