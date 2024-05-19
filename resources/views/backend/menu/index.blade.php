@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<h1>Kelola Data Menu</h1>
<div class="section-header-breadcrumb">
<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Setting</a></div>
<div class="breadcrumb-item"><a href="{{ route('menus.index') }}" data-nprogress>Menu</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Daftar Menu</h4>
                <div class="card-header-action">
                    <a href="{{ route('menus.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i>&nbsp;Tambah Menu
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="menu-table" class="table table-bordered" style="margin-top: 1rem;">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Parent Menu</th>                        
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('custom-javascript')
<!-- JS Libraies -->
<script src="{{ asset('assets/backend/stisla/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/backend/stisla/js/page/modules-datatables.js') }}"></script>
@endsection

@push('scripts')
<script>
$(function () {
    initializeDataTable('#menu-table', "{{ route('menus.data') }}", [
        {
                data: null,
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
        { data: 'title', name: 'title' },
        { data: 'url', name: 'url' },
        { data: 'icon', name: 'icon' },
        { data: 'parent', name: 'parent'},        
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]);
});
</script>
@endpush
