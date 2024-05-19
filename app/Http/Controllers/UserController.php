<?php

namespace App\Http\Controllers;

use App\Utilities\DataUtility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use DataUtility;
    
    public function index()
    {
        return view('backend.users.index');
    }

    public function getUserData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');

        $searchColumns = ['users.name', 'roles.name']; // Kolom yang ingin dicari

        $format = [
            'id' => 'id',
            'name' => function ($user) {
                return '<a href="' . route('users.edit', $user->id) . '">' . $user->name . '</a>';
            },
            'email' => 'email',
            'roles' => function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            },
            'action' => function ($user) {
                return $this->simpleButtons($user, 'users.destroy');
            },
        ];

        $data = $this->getData($request, User::class, $start, $length, $search, $searchColumns, $format);

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
        
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'array', // Validasi inputan roles sebagai array
        ]);
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        
            // Menyimpan peran (roles) terpilih
            if ($request->has('roles')) {
                $user->roles()->attach($request->roles);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Menambah Data : ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            Session::flash('error', $errorMessage);
            return redirect()->back();
        }

        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('backend.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles' => 'array',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            // Menyimpan peran (roles) terpilih
            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            } else {
                $user->roles()->detach(); // Menghapus semua peran (roles) jika tidak ada peran yang dipilih
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah data']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Mengubah data : '. $e->getMessage()]);
        }

    }

    public function destroy(User $user)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin menghapus data ini';
            return response()->json(['success' => false, 'message' => $errorMessage]);
        }

        DB::beginTransaction();
        try {
            // Menghapus role yang terkait dengan user
            $user->roles()->detach();
            $user->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Proses Hapus data berhasil']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data : ' . $e->getMessage()]);
        }
    
    }
}
