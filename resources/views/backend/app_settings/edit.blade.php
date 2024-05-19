@extends('backend.app')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('assets/backend/stisla/css/custom.css') }}">
@endsection

@section('breadcrumb')
<h1>Kelola Data Pengguna</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="#">Setting</a></div>
    <div class="breadcrumb-item"><a href="{{ route('app-settings.index') }}">Pengaturan Aplikasi</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h4>Ubah Pengaturan Aplikasi</h4>
                <div class="card-header-action">
                    <a href="{{ route('app-settings.index') }}" class="btn btn-primary">
                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="appSettingForm" action="{{ route('app-settings.update', $appSetting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <fieldset class="form-group custom-fieldset">
                        <legend>Item Pengaturan</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="setting_key">Setting Key</label>
                                    <input type="text" name="setting_key" id="setting_key" class="form-control" value="{{ $appSetting->setting_key }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="setting_value">Setting Value</label>
                                    <input type="text" name="setting_value" id="setting_value" class="form-control" value="{{ $appSetting->setting_value }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control">{{ $appSetting->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
        
                    <button type="submit" class="btn btn-icon icon-left btn-sm btn-danger" data-nprogress><i class="fas fa-save"></i>&nbsp;Update</button>
                    <a href="{{ route('app-settings.index') }}" class="btn btn-icon icon-left btn-sm btn-dark" data-nprogress><i class="fas fa-retweet"></i>&nbsp;Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')

<script>
$(document).ready(function() {

    // Menangkap event submit form
    $('#appSettingForm').submit(function(event) {
        event.preventDefault(); // Menghentikan form submit secara default

        var form = $(this);
        handleFormUpdate(
            form,
            function(response) {
                // Berhasil mengupdate data, tambahkan kode yang ingin Anda lakukan setelahnya
                window.location.href = '{{ route("app-settings.index") }}'; // Redirect ke halaman index pengaturan aplikasi
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
