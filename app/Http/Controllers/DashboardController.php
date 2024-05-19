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

        return view('backend.home', compact('dashboardView', 'contentHeader'));
    }
}
