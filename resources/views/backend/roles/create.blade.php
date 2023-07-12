@extends('backend.app')

@section('custom-css')

@endsection

@section('breadcrumb')
    <h1>
        Roles
        <small>Kelola Data Aturan Pengguna</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}" data-nprogress><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('roles.index') }}" data-nprogress><i class="fa fa-gears"></i>Roles</a></li>
    </ol>
@endsection

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Aturan/Roles</h3>
    </div>

    <div class="box-body">
        <form id="rolesForm" action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            
            <button type="submit" id="submitBtn" class="btn btn btn-flat btn-sm bg-maroon" data-nprogress><i class="fa fa-save"></i>&nbsp;Simpan</button>
            <a href="{{ route('roles.index') }}" class="btn btn-flat btn-sm bg-navy" data-nprogress><i class="fa fa-repeat"></i>&nbsp;Batal</a>
        </form>
    </div>
@endsection

@section('custom-js')

<script>
$(document).ready(function() {
    $('.select2').select2();

    // Menangkap event submit form
    $('#rolesForm').submit(function(event) {
        event.preventDefault(); // Menghentikan form submit secara default

        var form = $(this);
        handleFormSubmit(
            form,
            function(response) {
                window.location.href = '{{ route("roles.index") }}'; // Redirect ke halaman index roles
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