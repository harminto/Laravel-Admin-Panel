<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            ['title' => 'Dashboard', 'url' => 'home', 'icon' => 'fas fa-fire', 'parent_id' => NULL, 'order' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pengaturan', 'url' => '#', 'icon' => 'fas fa-pencil-ruler', 'parent_id' => NULL, 'order' => '200', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Manajemen Pengguna', 'url' => 'users.index', 'icon' => 'fas fa-users-cog', 'parent_id' => '2', 'order' => '210', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Manajemen Hak Akses', 'url' => 'hak-akses.index', 'icon' => 'fa fa-circle-o text-red', 'parent_id' => '2', 'order' => '220', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Manajemen Peran', 'url' => 'roles.index', 'icon' => 'fa fa-circle-o text-red', 'parent_id' => '2', 'order' => '230', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Menu Backend', 'url' => 'menus.index', 'icon' => 'fa fa-circle-o text-red', 'parent_id' => '2', 'order' => '240', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'App Setting', 'url' => 'app-settings.index', 'icon' => 'fa fa-circle-o text-red', 'parent_id' => '2', 'order' => '250', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
