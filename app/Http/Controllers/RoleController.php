<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Utilities\DataUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    use DataUtility;

    public function index()
    {
        return view('backend.roles.index');
    }
    
    public function getMenuData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');

        $searchColumns = ['roles.name'];

        $format = [
            'id' => 'id',
            'name' => function ($role) {
                return '<a href="' . route('roles.edit', $role->id) . '">' . $role->name . '</a>';
            },
            'action' => function ($role) {
                return $this->simpleButtons($role, 'roles.destroy');
            },
        ];

        $data = $this->getData($request, Role::class, $start, $length, $search, $searchColumns, $format);

        $data['draw'] = $draw;

        return response()->json($data);
    }

    public function create()
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            Session::flash('error', $errorMessage);
            return redirect()->back();
        }

        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        DB::beginTransaction();
        try {
            $role = new Role;
            $role->name = $request->input('name');
            $role->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Menambah Data : ' . $e->getMessage()]);
        }
    }

    public function edit(Role $role)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            Session::flash('error', $errorMessage);
            return redirect()->back();
        }
        return view('backend.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
        ]);

        DB::beginTransaction();
        try {
            $role->name = $request->input('name');
            $role->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah data']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Mengubah data : '. $e->getMessage()]);
        }    
    }

    public function destroy(Role $role)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin menghapus data ini';
            return response()->json(['success' => false, 'message' => $errorMessage]);
        }

        DB::beginTransaction();
        try {
            $role->delete();
            
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Proses Hapus data berhasil']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data : ' . $e->getMessage()]);
        }
    }
    
}
