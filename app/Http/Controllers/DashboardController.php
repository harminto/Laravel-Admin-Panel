<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userRoles = auth()->user()->roles;
        
        $dashboardView = 'backend.dashboard.default';
        $contentHeader = 'Dashboard';
        
        foreach ($userRoles as $role) {
            $roleView = 'backend.dashboard.' . strtolower(str_replace(' ', '_', $role->name));
            if (view()->exists($roleView)) {
                $dashboardView = $roleView;
                $contentHeader = ucfirst($role->name);
                break;
            }
        }
    
        return view($dashboardView, compact('contentHeader'));
    }
}
