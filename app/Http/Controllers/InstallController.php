<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    public function index()
    {
        return view('install.index');
    }

    public function install(Request $request)
    {
        // Validasi input
        $request->validate([
            'database' => 'required',
            'username' => 'required',
            'host' => 'required',
            'port' => 'required',
        ]);

        // Konfigurasi sementara untuk koneksi tanpa database (gunakan database sistem default)
        $tempConfig = [
            'driver' => 'mysql',
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'database' => 'information_schema', // Database sistem default
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];

        config(['database.connections.temp' => $tempConfig]);

        // Logging konfigurasi untuk debugging
        Log::info('Temporary database configuration:', $tempConfig);

        // Coba koneksi ke server database
        try {
            DB::connection('temp')->getPdo();

            // Buat database jika belum ada
            $dbName = $request->database;
            DB::connection('temp')->statement("CREATE DATABASE IF NOT EXISTS `$dbName`");
        } catch (\Exception $e) {
            Log::error('Database connection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not connect to the database. Please check your configuration.');
        }

        // Update konfigurasi database untuk menggunakan database baru
        $config = [
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $request->host,
            'DB_PORT' => $request->port,
            'DB_DATABASE' => $request->database,
            'DB_USERNAME' => $request->username,
            'DB_PASSWORD' => $request->password,
        ];

        $this->updateEnvironmentFile($config);

        // Refresh konfigurasi untuk menggunakan database baru
        $newConfig = [
            'driver' => 'mysql',
            'host' => $request->host,
            'port' => $request->port,
            'database' => $request->database,
            'username' => $request->username,
            'password' => $request->password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];

        config(['database.connections.mysql' => $newConfig]);

        // Logging konfigurasi baru untuk debugging
        Log::info('New database configuration:', $newConfig);

        // Coba koneksi ke database yang baru dibuat
        try {
            DB::purge('mysql');
            DB::reconnect('mysql');
            DB::connection('mysql')->getPdo();
        } catch (\Exception $e) {
            Log::error('Database connection error after creating database: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not connect to the new database. Please check your configuration.');
        }

        // Jalankan migrasi dan seeding database
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
        } catch (\Exception $e) {
            Log::error('Migration or seeding error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during database migration or seeding. Please check your configuration.');
        }

        // Redirect ke halaman instalasi selesai
        return redirect()->route('login')->with('success', 'Installation complete. You can now log in.');
    }

    protected function updateEnvironmentFile(array $data)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $envContent);
        }

        file_put_contents($envPath, $envContent);
    }
}
