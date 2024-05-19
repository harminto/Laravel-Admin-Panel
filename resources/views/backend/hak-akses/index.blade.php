@extends('backend.app')

@section('custom-css')
@endsection

@section('breadcrumb')
<h1>Hak Akses Menu</h1>
<div class="section-header-breadcrumb">
<div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
<div class="breadcrumb-item"><a href="#">Setting</a></div>
<div class="breadcrumb-item"><a href="{{ route('hak-akses.index') }}" data-nprogress>Hak Akses</a></div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Peran - Hak Akses</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8 col-md-8 col-lg-8">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                @foreach ($roles as $index => $role)
                                    <li class="nav-item"><a class="nav-link {{ $index === 0 ? 'active' : '' }}" href="#tab_{{ $role->id }}" data-toggle="tab">{{ $role->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content">
                            @foreach ($roles as $index => $role)
                                <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="tab_{{ $role->id }}">
                                    <table class="table table-sm table-striped">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Menu Navigasi</th>
                                            <th>Status</th>
                                        </tr>
                                        <tbody>
                                        @foreach ($menus->filter(function ($menu) {
                                            return $menu->parent_id === null;
                                        }) as $menu)
                                            @if ($menu->parent_id === null)
                                                <tr>
                                                    <td style="width: 10px"><i class="fas fa-chevron-circle-right"></i></td>
                                                    <td><b>{{ $menu->title }}</b>&nbsp; *</td>
                                                    <td>                                                        
                                                        <input type="checkbox" class="minimal-red"  data-menu-id="{{ $menu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$menu->id]) ? 'checked' : '' }}>
                                                        <span class="status-text"></span>                                                        
                                                    </td>
                                                </tr>
                                                @foreach ($menus->filter(function($item) use ($menu) {
                                                    return $item->parent_id === $menu->id;
                                                }) as $childMenu)
                                                    <tr>
                                                        <td style="width: 10px"></td>
                                                        <td style="padding-left: 20px"><i class="fab fa-gg-circle"></i>&nbsp;&nbsp;{{ $childMenu->title }}</td>
                                                        <td>                                                    
                                                            <input type="checkbox" class="minimal-red" data-menu-id="{{ $childMenu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$childMenu->id]) ? 'checked' : '' }}>
                                                            <span class="status-text"></span>
                                                        </td>
                                                    </tr>
                                                    @foreach ($menus->filter(function($item) use ($childMenu) {
                                                        return $item->parent_id === $childMenu->id;
                                                    }) as $subMenu)
                                                        <tr>
                                                            <td style="width: 10px"></td>
                                                            <td style="padding-left: 40px">{{ $subMenu->title }}</td>
                                                            <td>                        
                                                                <input type="checkbox" class="minimal-red" data-menu-id="{{ $subMenu->id }}" data-role-id="{{ $role->id }}" {{ isset($hakAksesArray[$role->id][$subMenu->id]) ? 'checked' : '' }}>
                                                                <span class="status-text"></span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4">
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
<script>
$(function () {
    // Event checkbox diubah
    $('input[type="checkbox"].minimal-red').on('change', function (event) {
        //var isChecked = event.target.checked;
        var isChecked = $(this).is(':checked');
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