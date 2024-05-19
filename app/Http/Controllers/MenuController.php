<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;
use App\Utilities\DataUtility;

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
