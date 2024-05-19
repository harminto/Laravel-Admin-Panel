<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_menu')->insert([
            ['role_id' => 1, 'menu_id' => 1, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 2, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 3, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 4, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 5, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 6, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'menu_id' => 7, 'permissions' => '{"edit":true,"view":true,"create":true,"delete":true}', 'created_at' => now(), 'updated_at' => now()],
        ]);        
    }
}
