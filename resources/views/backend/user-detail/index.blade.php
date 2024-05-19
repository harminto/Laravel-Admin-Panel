@extends('backend.app')

@section('breadcrumb')
    <h1>
        Nasabah Detail
        <small>Kelola Data Nasabah Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('user-details.index') }}"><i class="fa fa-user"></i>Nasabah Detail</a></li>
    </ol>
@endsection

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Nasabah Detail</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('user-details.create') }}" class="btn btn-sm btn-success">
                <i class="fa fa-plus-circle"></i>&nbsp;
                Tambah Nasabah Detail
            </a>
        </div>
    </div>
    <div class="box-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table id="user-details-table" class="table table-bordered" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Rekening</th>
                    <th>Alamat</th>
                    <th>No KTP</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            initializeDataTable('#user-details-table', "{{ route('user-details.data') }}", [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'no_rekening', name: 'no_rekening' },
                { data: 'alamat', name: 'alamat' },
                { data: 'no_ktp', name: 'no_ktp' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]);
        });
    </script>
@endpush
