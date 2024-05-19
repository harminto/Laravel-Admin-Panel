@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/select2/dist/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
<h1>Dashboard</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
    <div class="breadcrumb-item"><a href="#">{{ $contentHeader }}</a></div>
</div>
@endsection


@section('content')
    <div class="row">
        @yield('content-dashboard')
    </div>
@endsection

@section('custom-javascript')
<!-- JS Libraries -->
<script src="{{ asset('assets/backend/stisla/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/backend/stisla/js/page/modules-datatables.js') }}"></script>
<script src="{{ asset('assets/backend/stisla/modules/select2/dist/js/select2.full.min.js') }}"></script>
@endsection

@push('scripts')
<script>


</script>
@endpush
