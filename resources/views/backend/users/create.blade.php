@extends('backend.app')

@section('custom-css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
<h1>
    Pengguna
    <small>Kelola Data Pengguna</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="{{ route('users.index') }}"><i class="fa fa-user"></i>Pengguna</a></li>
</ol>
@endsection

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Tambah Pengguna</h3>
</div>

<div class="box-body">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="roles">Roles</label>
            <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required style="width: 100%;">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-save"></i>&nbsp;Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i>&nbsp;Batal</a>
        
    </form>
</div>
@endsection

@section('custom-js')
<!-- Select2 -->
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection
