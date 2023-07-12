<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reward::create([
            'reward_name' => 'Voucher Belanja',
            'description' => 'Voucher belanja senilai Rp 50.000',
            'required_points' => 100,
            'image' => 'voucher.jpg',
        ]);

        Reward::create([
            'reward_name' => 'Tumbler',
            'description' => 'Tumbler berkualitas',
            'required_points' => 50,
            'image' => 'tumbler.jpg',
        ]);
    }
}
