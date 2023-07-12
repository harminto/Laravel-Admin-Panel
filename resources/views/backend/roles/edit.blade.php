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
        <h3 class="box-title">Ubah Aturan/Roles</h3>
    </div>

    <div class="box-body">
    <form id="menusForm" action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}">
        </div>

        <button type="submit" class="btn btn-sm btn-flat bg-maroon" data-nprogress><i class="fa fa-save"></i>&nbsp;Update</button>
        <a href="{{ route('roles.index') }}" class="btn btn-flat btn-sm bg-navy" data-nprogress><i class="fa fa-repeat"></i>&nbsp;Batal</a>
    </form>
</div>

@endsection

@section('custom-js')

<script>
$(document).ready(function() {

    // Menangkap event submit form
    $('#menusForm').submit(function(event) {
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