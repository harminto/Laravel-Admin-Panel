<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Utilities\DataUtility;

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
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        try {
            $role = new Role;
            $role->name = $request->input('name');
            $role->save();

            return response()->json(['success' => true, 'message' => 'Roles created successfully']);
        } catch (\Exception $e) {
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
            $role->name = $request->input('name');
            $role->save();

            return response()->json(['success' => true, 'message' => 'Roles update successfully']);
        } catch (\Exception $e) {
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
