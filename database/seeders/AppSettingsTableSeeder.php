<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_settings')->insert([
            ['setting_key' => 'short_name', 'setting_value' => 'Minto`s CMS', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'long_name', 'setting_value' => 'Master CMS buatan sendiri', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_mail', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_fb', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_ig', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_yt', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_linkedin', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_twitter', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_contact', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['setting_key' => 'app_alamat', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
