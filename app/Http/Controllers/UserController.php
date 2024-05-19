<?php

namespace App\Http\Controllers;

use App\Utilities\DataUtility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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
            return response()->json(['success' => true, 'message' => 'Users created successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to create Users']);
        }
    }

    public function edit(User $user)
    {
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
            return response()->json(['success' => true, 'message' => 'Users update successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to update Users']);
        }

    }

    public function destroy(User $user)
    {
        try {
            // Menghapus role yang terkait dengan user
            $user->roles()->detach();
            $user->delete();

            return response()->json(['message' => 'Users deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    
    }
}
