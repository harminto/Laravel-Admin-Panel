@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/custom.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/modules/select2/dist/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
<h1>Kelola Data Menu</h1>
<div class="section-header-breadcrumb">
<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Setting</a></div>
<div class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menu</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h4>Tambah Menu</h4>
                <div class="card-header-action">
                    <a href="{{ route('menus.index') }}" class="btn btn-primary">
                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="menusForm" action="{{ route('menus.store') }}" method="POST">
                    @csrf
                    <fieldset class="form-group custom-fieldset">
                        <legend>Item Menu</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" name="url" id="url" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="icon">Icon</label>
                                    <input type="text" name="icon" id="icon" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_id">Parent Menu</label>
                                    <select name="parent_id" id="parent_id" class="form-control select2">
                                        <option value="">No Parent</option>
                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ $menu->order }}" required>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" id="submitBtn" class="btn btn-icon icon-left btn-sm btn-danger" data-nprogress><i class="fas fa-save"></i>&nbsp;Simpan</button>
                    <a href="{{ route('menus.index') }}" class="btn btn-icon icon-left btn-sm btn-dark" data-nprogress><i class="fas fa-retweet"></i>&nbsp;Batal</a>
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
            $('#menusForm').submit(function(event) {
                event.preventDefault(); // Menghentikan form submit secara default

                var form = $(this);
                handleFormSubmit(
                    form,
                    function(response) {
                        // Berhasil menyimpan data, tambahkan kode yang ingin Anda lakukan setelahnya
                        showSuccessToast(response.message);
                        window.location.href = '{{ route("menus.index") }}'; // Redirect ke halaman index menus
                    },
                    function(error) {
                        // Error dalam menyimpan data, tambahkan kode yang ingin Anda lakukan setelahnya
                        console.log(error);
                    }
                );
            });
        });
    </script>
@endsection
