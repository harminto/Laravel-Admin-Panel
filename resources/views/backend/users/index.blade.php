@extends('backend.app')

@section('breadcrumb')
<h1>
    Pengguna
    <small>Kelola Data Pengguna</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="{{ route('users.index') }}"><i class="fa fa-user"></i>Pengguna</li>
</ol>
@endsection

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Daftar Pengguna</h3>
    <div class="box-tools pull-right">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
            <i class="fa fa-plus-circle"></i>&nbsp;
            Tambah Pengguna
        </a>
    </div>
</div>
<div class="box-body">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="table table-bordered" style="margin-top: 1rem;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                            </div>
                            <div class="btn-group">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fa fa-trash"></i>&nbsp;Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

