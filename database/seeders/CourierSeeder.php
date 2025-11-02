<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Courier;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couriers = [
            ['name' => 'Servientrega', 'is_active' => true],
            ['name' => 'Laar', 'is_active' => true],
            ['name' => 'Tramaco', 'is_active' => true],
            ['name' => 'Urbano', 'is_active' => true],
            ['name' => 'Coordinadora', 'is_active' => true],
        ];

        foreach ($couriers as $courier) {
            Courier::create($courier);
        }

        $this->command->info('✅ 5 couriers creados exitosamente');
    }
}
