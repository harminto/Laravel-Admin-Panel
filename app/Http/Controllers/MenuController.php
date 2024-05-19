<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Utilities\DataUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    use DataUtility;

    public function index()
    {
        return view('backend.menu.index');
    }

    public function getMenuData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');

        $searchColumns = ['menus.title'];

        $format = [
            'id' => 'id',
            'title' => function ($menu) {
                return '<a href="' . route('menus.edit', $menu->id) . '">' . $menu->title . '</a>';
            },
            'url'  => function ($menu) {
                return $menu->url;
            },
            'icon' => 'icon',
            'parent' => function ($menu) {
                return $menu->parent ? $menu->parent->title : '';
            },
            'action' => function ($menu) {
                return $this->simpleButtons($menu, 'menus.destroy');
            },
        ];

        $data = $this->getData($request, Menu::class, $start, $length, $search, $searchColumns, $format);

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

        $menus = Menu::get();

        return view('backend.menu.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Menu::create($request->all());
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Menambah Data : ' . $e->getMessage()]);
        }
    }

    
    public function show($id)
    {
        
    }

    
    public function edit(Menu $menu)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            Session::flash('error', $errorMessage);
            return redirect()->back();
        }

        $menus = Menu::get();

        return view('backend.menu.edit', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $menu->update($request->all());

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil mengubah data']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal Mengubah data : '. $e->getMessage()]);
        }
    }


    public function destroy(Menu $menu)
    {
        $permission = $this->getPermissions(Auth::id(), request()->route()->getName());
        if (!$permission) {
            $errorMessage = 'Anda tidak memiliki izin menghapus data ini';
            return response()->json(['success' => false, 'message' => $errorMessage]);
        }

        DB::beginTransaction();
        try {
            $menu->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Proses Hapus data berhasil']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data : ' . $e->getMessage()]);
        }
    }
    
}
