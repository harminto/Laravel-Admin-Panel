<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('backend.roles.index');
    }
    
    public function getMenuData(Request $request)
    {
        $draw = $request->input('draw'); // Nomor permintaan draw
        $start = $request->input('start'); // Indeks awal data yang akan ditampilkan
        $length = $request->input('length'); // Jumlah entri per halaman
        $search = $request->input('search.value'); // Kata kunci pencarian

        // Query untuk mengambil data dengan batasan halaman dan entri per halaman
        $roles = Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->skip($start)
        ->take($length)
        ->get();

        $data = [];
        foreach ($roles as $role) {
            // Memformat data sesuai dengan format yang diharapkan oleh DataTables
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'action' => '
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group">
                            <a href="'.route('roles.edit', $role->id).'" class="btn btn-flat btn-sm btn-primary" data-nprogress><i class="fa fa-edit"></i>&nbsp;Edit</a>
                        </div>
                        <div class="btn-group">
                            <form onsubmit="handleFormDelete(event)" action="'.route('roles.destroy', $role->id).'" method="POST" class="d-inline">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress><i class="fa fa-trash"></i>&nbsp;Delete</button>
                            </form>
                        </div>
                    </div>
                ',
            ];
        }

        $total = Role::count(); // Jumlah total entri (tanpa mempertimbangkan batasan halaman)

        // Menyiapkan respons JSON yang sesuai dengan format yang diharapkan oleh DataTables
        $response = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        try {
            // Membuat role baru
            $role = new Role;
            $role->name = $request->input('name');
            $role->save();

            return response()->json(['success' => true, 'message' => 'Roles created successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to create roles']);
        }
    }

    public function edit(Role $role)
    {
        return view('backend.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
        ]);

        try {
            // Mengupdate role
            $role->name = $request->input('name');
            $role->save();

            return response()->json(['success' => true, 'message' => 'Roles update successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to update roles']);
        }    
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            
            return response()->json(['message' => 'Role deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }
}
