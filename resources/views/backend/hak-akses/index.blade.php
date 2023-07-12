@extends('backend.app')

@section('custom-css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
@endsection

@section('breadcrumb')
    <h1>
        Hak Akses
        <small>Kelola Hak Akses Navigasi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}" data-nprogress><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ route('hak-akses.index') }}" data-nprogress><i class="fa fa-bars"></i> Hak Akses</a></li>
    </ol>
@endsection

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Peran - Hak Akses</h3>
        <div class="box-tools pull-right">
            
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @foreach ($roles as $index => $role)
                            <li class="{{ $index === 0 ? 'active' : '' }}"><a href="#tab_{{ $role->id }}" data-toggle="tab">{{ $role->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach ($roles as $index => $role)
                        <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="tab_{{ $role->id }}">
                            <table class="table">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Menu Navigasi</th>
                                    <th>Status</th>
                                </tr>
                                @foreach ($menus->filter(function ($menu) {
                                    return $menu->parent_id === null;
                                }) as $menu)
                                    @if ($menu->parent_id === null)
                                        <tr>
                                            <td style="width: 10px"><i class="fa fa-circle-o text-red"></i></td>
                                            <td><b>{{ $menu->title }}</b>&nbsp; *</td>
                                            <td>
                                                <div class="form-group">
                                                    <label>
                                                    <input type="checkbox" class="minimal-red" data-menu-id="{{ $menu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$menu->id]) ? 'checked' : '' }}>
                                                    <span class="status-text"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach ($menus->filter(function($item) use ($menu) {
                                            return $item->parent_id === $menu->id;
                                        }) as $childMenu)
                                            <tr>
                                                <td style="width: 10px"></td>
                                                <td style="padding-left: 20px"><i class="fa fa-circle-o text-aqua"></i>&nbsp;&nbsp;{{ $childMenu->title }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" class="minimal-red" data-menu-id="{{ $childMenu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$childMenu->id]) ? 'checked' : '' }}>
                                                            <span class="status-text"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach ($menus->filter(function($item) use ($childMenu) {
                                                return $item->parent_id === $childMenu->id;
                                            }) as $subMenu)
                                                <tr>
                                                    <td style="width: 10px"></td>
                                                    <td style="padding-left: 40px">{{ $subMenu->title }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>
                                                            <input type="checkbox" class="minimal-red" data-menu-id="{{ $subMenu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$subMenu->id]) ? 'checked' : '' }}>
                                                                <span class="status-text"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-warning"></i>
                        <h3 class="box-title">Alerts</h3>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-danger alert-dismissible">
                            <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
                            Untuk memilih sub menu Aktif<br>
                            > Wajib men-Checklist Menu Utama yang <b>dicetak tebal</b> dan ditandai (*) di atasnya
                            <br><br>
                            Contoh: <br>
                            > Untuk Mengaktifkan menu Peran, maka menu Administrasi harus di pilih<br>
                            > Secara default, semua hak akses pengguna mendapatkan hak akses menu Dashboard
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script>
$(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
    })

    // Event checkbox diubah
    $('input[type="checkbox"].minimal-red').on('ifChanged', function (event) {
        var isChecked = event.target.checked;
        var menuId = $(this).data('menu-id');
        var roleId = $(this).data('role-id');

        // Kirim data ke server menggunakan Ajax
        $.ajax({
            url: '{{ route("hak-akses.store") }}',
            type: 'POST',
            data: {
                menu_id: menuId,
                role_id: roleId,
                checked: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                showSuccessToast(response.message);
                // console.log(response); // Tindakan lanjutan setelah penyimpanan berhasil
            },
            error: function (xhr, status, error) {
                showErrorToast(xhr.responseText);
                //console.log(xhr.responseText); // Penanganan kesalahan
            }
        });
    });
});
</script>
@endsection