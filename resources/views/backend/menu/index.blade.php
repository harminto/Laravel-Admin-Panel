@extends('backend.app')

@section('breadcrumb')
    <h1>
        Menus
        <small>Kelola Menu Navigasi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}" data-nprogress><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('menus.index') }}" data-nprogress><i class="fa fa-bars"></i> Menus</a></li>
    </ol>
@endsection

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Menu</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('menus.create') }}" class="btn btn-flat btn-sm btn-success" data-nprogress>
                <i class="fa fa-plus-circle"></i>&nbsp;
                Tambah Menu
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
            <table id="menu-table" class="table table-bordered" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Parent Menu</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(function () {
    initializeDataTable('#menu-table', "{{ route('menus.data') }}", [
        { data: 'id', name: 'id' },
        { data: 'title', name: 'title' },
        { data: 'url', name: 'url' },
        { data: 'icon', name: 'icon' },
        { data: 'parent', name: 'parent.title', defaultContent: '' },        
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]);
});
</script>
@endpush
