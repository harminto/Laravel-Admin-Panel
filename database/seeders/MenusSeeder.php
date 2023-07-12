<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::insert([
            [
                'id' => 1,
                'title' => 'Dashboard',
                'url' => 'home',
                'icon' => 'fa fa-dashboard text-red',
                'parent_id' => NULL,
                'order' => 100,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 2,
                'title' => 'Pengaturan',
                'url' => '#',
                'icon' => 'fa fa-gears text-red',
                'parent_id' => NULL,
                'order' => 100,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 3,
                'title' => 'Manajemen Pengguna',
                'url' => 'users.index',
                'icon' => 'fa fa-circle-o text-red',
                'parent_id' => 2,
                'order' => 100,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 4,
                'title' => 'Manajemen Hak Akses',
                'url' => 'hak-akses.index',
                'icon' => 'fa fa-circle-o text-red',
                'parent_id' => 2,
                'order' => 300,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 5,
                'title' => 'Manajemen Peran',
                'url' => 'roles.index',
                'icon' => 'fa fa-circle-o text-aqua',
                'parent_id' => 2,
                'order' => 200,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 6,
                'title' => 'Menu Backend',
                'url' => 'menus.index',
                'icon' => 'fa fa-circle-o text-red',
                'parent_id' => 2,
                'order' => 400,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        ]);
    }
}
