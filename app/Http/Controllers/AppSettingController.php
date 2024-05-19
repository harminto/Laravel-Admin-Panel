<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Utilities\DataUtility;

class AppSettingController extends Controller
{
    use DataUtility;

    public function index()
    {
        return view('backend.app_settings.index');
    }

    public function getAppSettingData(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');

        $searchColumns = ['app_settings.setting_key', 'app_settings.setting_value', 'app_settings.description'];

        $format = [
            'id' => 'id',
            'setting_key' => function ($appSetting) {
                return '<a href="' . route('app-settings.edit', $appSetting->id) . '">' . $appSetting->setting_key . '</a>';
            },
            'setting_value' => 'setting_value',
            'description' => 'description',
        ];

        $data = $this->getData($request, AppSetting::class, $start, $length, $search, $searchColumns, $format);

        $data['draw'] = $draw;

        return response()->json($data);
    }

    public function create()
    {
        return view('backend.app_settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'setting_key' => 'required|unique:app_settings|max:255',
            'setting_value' => 'required',
            'description' => 'nullable',
        ]);

        try {
            AppSetting::create($request->all());

            return response()->json(['success' => true, 'message' => 'App Setting created successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create App Setting']);
        }
    }

    public function edit(AppSetting $appSetting)
    {
        return view('backend.app_settings.edit', compact('appSetting'));
    }

    public function update(Request $request, AppSetting $appSetting)
    {
        $request->validate([
            'setting_key' => 'required|unique:app_settings,setting_key,' . $appSetting->id . '|max:255',
            'setting_value' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $appSetting->update($request->all());

            return response()->json(['success' => true, 'message' => 'App Setting updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update App Setting']);
        }
    }

    public function destroy(AppSetting $appSetting)
    {
        try {
            $appSetting->delete();
            
            return response()->json(['message' => 'App Setting deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
