<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Menu;
use App\Models\HakAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HakAksesController extends Controller
{
    /* public function index()
    {
        $roles = Role::with('menus')->get();
        $menus = Menu::with('parent')->get();
        
        // Mendapatkan data HakAkses untuk penandaan checkbox
        $hakAkses = HakAkses::select('role_id', 'menu_id')->get()->toArray();

        $hakAksesArray = []; // Array untuk menampung data hak akses
        
        foreach ($hakAkses as $item) {
            $hakAksesArray[$item['role_id']][$item['menu_id']] = true;
        }

        return view('backend.hak-akses.index', compact('roles', 'menus', 'hakAksesArray'));

    } */

    public function index()
    {
        $roles = Role::with('menus')->get();
        $menus = Menu::with('parent')->get();

        // Mendapatkan data HakAkses beserta permissions untuk penandaan checkbox
        $hakAkses = HakAkses::all();

        // Buat array untuk menampung data hak akses dan permissions
        $hakAksesArray = [];

        foreach ($hakAkses as $roleMenu) {
            $hakAksesArray[$roleMenu->role_id][$roleMenu->menu_id] = [
                'view' => $roleMenu->permissions['view'] ?? false,
                'create' => $roleMenu->permissions['create'] ?? false,
                'edit' => $roleMenu->permissions['edit'] ?? false,
                'delete' => $roleMenu->permissions['delete'] ?? false,
            ];
        }

        return view('backend.hak-akses.index', compact('roles', 'menus', 'hakAksesArray'));
    }
    /* public function store(Request $request)
    {
        $menuId = $request->input('menu_id');
        $roleId = $request->input('role_id');
        $isChecked = $request->input('checked') == 1; // Convert to boolean

        try {
            if ($isChecked) {
                // If checkbox is checked, add HakAkses record if it doesn't exist
                $hakAkses = HakAkses::firstOrCreate(['menu_id' => $menuId, 'role_id' => $roleId]);
            } else {
                // If checkbox is unchecked, delete HakAkses record if it exists
                HakAkses::where('menu_id', $menuId)
                    ->where('role_id', $roleId)
                    ->delete();
                
                $hakAkses = null; // Set $hakAkses to null since the record is deleted
            }

            // Respon JSON yang sesuai
            return response()->json([
                'message' => 'Data hak akses berhasil disimpan.',
                'hak_akses' => $hakAkses
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat menyimpan data hak akses: ' . $e->getMessage();
            return response()->json([
                'message' => $errorMessage,
                'error' => $e->getMessage()
            ], 500);
        }
    } */

    public function store(Request $request)
    {
        $menuId = $request->input('menu_id');
        $roleId = $request->input('role_id');
        $isChecked = $request->input('checked') == 1;
        $permission = $request->input('permission');

        try {
            $hakAkses = HakAkses::where('menu_id', $menuId)
                ->where('role_id', $roleId)
                ->first();

            if ($hakAkses) {
                $permissions = $hakAkses->permissions ?? [];

                if ($isChecked) {
                    $permissions[$permission] = true;
                } else {
                    unset($permissions[$permission]);
                }

                if (empty($permissions)) {
                    $hakAkses->delete();
                    $hakAkses = null;
                } else {
                    $hakAkses->permissions = $permissions;
                    $hakAkses->save();
                }
            } elseif ($isChecked) {
                $hakAkses = HakAkses::create([
                    'menu_id' => $menuId,
                    'role_id' => $roleId,
                    'permissions' => [$permission => true]
                ]);
            }

            return response()->json([
                'message' => 'Data hak akses berhasil disimpan.',
                'hak_akses' => $hakAkses
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat menyimpan data hak akses: ' . $e->getMessage();

            return response()->json([
                'message' => $errorMessage,
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
