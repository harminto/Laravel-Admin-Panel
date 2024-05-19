<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'user_id' => 1, // Assuming the first user is the admin
            'role_id' => 1, // Assuming the first role is 'Admin'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
