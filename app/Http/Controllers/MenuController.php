<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;

class MenuController extends Controller
{
    public function index()
    {
        return view('backend.menu.index');
    }

    public function getMenuData(Request $request)
    {
        $draw = $request->input('draw'); // Nomor permintaan draw
        $start = $request->input('start'); // Indeks awal data yang akan ditampilkan
        $length = $request->input('length'); // Jumlah entri per halaman
        $search = $request->input('search.value'); // Kata kunci pencarian

        // Query untuk mengambil data dengan batasan halaman dan entri per halaman
        $menus = Menu::when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('order')
            ->skip($start)
            ->take($length)
            ->get();

        $data = [];
        foreach ($menus as $menu) {
            // Memformat data sesuai dengan format yang diharapkan oleh DataTables
            $data[] = [
                'id' => $menu->id,
                'title' => $menu->title,
                'url' => $menu->url,
                'icon' => $menu->icon,
                'parent' => $menu->parent ? $menu->parent->title : '',
                'action' => '
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group">
                            <a href="'.route('menus.edit', $menu->id).'" class="btn btn-flat btn-sm btn-primary" data-nprogress><i class="fa fa-edit"></i>&nbsp;Edit</a>
                        </div>
                        <div class="btn-group">
                            <form onsubmit="handleFormDelete(event)" action="'.route('menus.destroy', $menu->id).'" method="POST" class="d-inline">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress><i class="fa fa-trash"></i>&nbsp;Delete</button>
                            </form>
                        </div>
                    </div>
                ',
            ];
        }

        $total = Menu::count(); // Jumlah total entri (tanpa mempertimbangkan batasan halaman)

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
        $menus = Menu::get();

        return view('backend.menu.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        try {
            Menu::create($request->all());
            return response()->json(['success' => true, 'message' => 'Menu created successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to create Menu']);
        }
    }

    
    public function show($id)
    {
        
    }

    
    public function edit(Menu $menu)
    {
        $menus = Menu::get();

        return view('backend.menu.edit', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        try {
            $menu->update($request->all());

            return response()->json(['success' => true, 'message' => 'Menu update successfully']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            return response()->json(['success' => false, 'message' => 'Failed to update Menu']);
        }
    }


    public function destroy(Menu $menu)
    {
        try {
            $menu->delete();

            return response()->json(['message' => 'Menu deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }
    
}
