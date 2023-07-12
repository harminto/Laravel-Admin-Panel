@extends('backend.app')

@section('custom-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
    <h1>
        Menus
        <small>Tambah Menu Navigasi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}" data-nprogress><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('menus.index') }}" data-nprogress><i class="fa fa-bars"></i> Menus</a></li>
    </ol>
@endsection

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Menu</h3>
    </div>

    <div class="box-body">
        <form id="menusForm" action="{{ route('menus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" name="url" id="url" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="icon">Icon</label>
                <input type="text" name="icon" id="icon" class="form-control">
            </div>
            <div class="form-group">
                <label for="parent_id">Parent Menu</label>
                <select name="parent_id" id="parent_id" class="form-control select2">
                    <option value="">No Parent</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="order" class="form-label">Order</label>
                <input type="number" class="form-control" id="order" name="order" value="{{ $menu->order }}" required>
            </div>
            
            <button type="submit" id="submitBtn" class="btn btn btn-flat btn-sm bg-maroon" data-nprogress><i class="fa fa-save"></i>&nbsp;Simpan</button>
            <a href="{{ route('menus.index') }}" class="btn btn-flat btn-sm bg-navy" data-nprogress><i class="fa fa-repeat"></i>&nbsp;Batal</a>
        </form>
    </div>
@endsection

@section('custom-js')
    <!-- Select2 -->
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

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
