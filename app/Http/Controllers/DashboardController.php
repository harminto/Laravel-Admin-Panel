<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $loadAverage = sys_getloadavg();
        $cpuUsage = round($loadAverage[0] * 100, -2);

        $ramUsage = memory_get_usage(true);
        
        return view('backend.home', compact('cpuUsage', 'ramUsage'));
    }
}
