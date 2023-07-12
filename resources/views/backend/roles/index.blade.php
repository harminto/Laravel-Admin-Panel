@extends('backend.app')

@section('breadcrumb')
<h1>
    Roles
    <small>Kelola Aturan Pengguna</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('home') }}" data-nprogress><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="{{ route('roles.index') }}" data-nprogress><i class="fa fa-gears"></i>Roles</a></li>
</ol>
@endsection

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Daftar Aturan</h3>
    <div class="box-tools pull-right">
        <a href="{{ route('roles.create') }}" class="btn btn-flat btn-sm btn-success" data-nprogress>
            <i class="fa fa-plus-circle"></i>&nbsp;
            Tambah Aturan
        </a>
    </div>
</div>
<div class="box-body">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="table-responsive">
        <table id="roles-table" class="table table-bordered" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    initializeDataTable('#roles-table', "{{ route('roles.data') }}", [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]);
});
</script>
@endpush