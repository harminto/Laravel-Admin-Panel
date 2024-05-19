<?php

use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/* Route::get('/', function () {
    return view('welcome');
}); */

/* buat capthca */
// Route::get('/captcha', [LandingController::class, 'captcha'])->name('captcha');

Route::middleware('check.installation')->group(function () {
    Route::get('/', [LoginController::class,'index']);

    Route::get('/login', [LoginController::class,'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [DashboardController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::post('/users/data', [UserController::class, 'getUserData'])->name('users.data');
        Route::resource('roles', RoleController::class);
        Route::post('/roles/data', [RoleController::class, 'getMenuData'])->name('roles.data');
        Route::resource('menus', MenuController::class);
        Route::post('/menus/data', [MenuController::class, 'getMenuData'])->name('menus.data');
        Route::resource('hak-akses', HakAksesController::class);
        
        Route::resource('app-settings', AppSettingController::class);
        Route::post('/app-settings/data', [AppSettingController::class, 'getAppSettingData'])->name('app-settings.data');
        
    });
});

Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'install'])->name('install.perform');