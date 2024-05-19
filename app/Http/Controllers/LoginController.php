<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function redirectTo()
    {
        return '/dashboard';
    }

    protected function authenticated(Request $request, User $user)
    {
        $roles = $user->roles;
        $permissions = $roles->flatMap(function ($role) {
            return $role->permissions;
        })->pluck('name')->unique();

        session(['roles' => $roles, 'permissions' => $permissions]);
    }

    public function username()
    {
        return 'email'; // Ganti dengan kolom yang digunakan sebagai username
    }

    public function index()
    {
        $appSetting = AppSetting::where('setting_key', 'short_name')->first();

        $judul = $appSetting ? $appSetting->setting_value : 'Custome CMS made by Minto`s Production';
        return view('backend.login', ['judul' => $judul]);
    }

    // Method untuk melakukan proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            // Login berhasil
            return response()->json([
                'message' => 'Login Berhasil',
                'redirect' => '/home'
            ], 200);
        } else {
            // Login gagal
            return response()->json([
                'errors' => [
                    'email' => ['Login GAGAL, Email atau password salah']
                ]
            ], 422);
        }
    }


    // Method untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Ganti dengan rute yang diinginkan setelah logout
    }

    protected function guard()
    {
        return Auth::guard(); // Anda juga dapat menentukan guard yang digunakan jika ada lebih dari satu
    }
}
