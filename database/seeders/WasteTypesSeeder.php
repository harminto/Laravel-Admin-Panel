<?php

namespace Database\Seeders;

use App\Models\WasteType;
use Illuminate\Database\Seeder;

class WasteTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WasteType::create([
            'waste_type_name' => 'Plastik',
            'description' => 'Sampah plastik',
            'exchange_value' => 0.05,
        ]);

        WasteType::create([
            'waste_type_name' => 'Kertas',
            'description' => 'Sampah kertas',
            'exchange_value' => 0.1,
        ]);
    }
}
