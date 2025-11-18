<?php

namespace Database\Seeders;

use App\Models\ShippingPrice;
use Illuminate\Database\Seeder;

class ShippingPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds the shipping prices based on price codes.
     */
    public function run(): void
    {
        $prices = [
            [
                'code_name' => 'MQ',
                'price' => 2.50,
                'courier_name' => 'METROPOLITANO QUITO',
                'description' => 'Zona metropolitana de Quito',
            ],
            [
                'code_name' => 'RE',
                'price' => 5.00,
                'courier_name' => 'RESTO ECUADOR',
                'description' => 'Resto del Ecuador continental',
            ],
            [
                'code_name' => 'O',
                'price' => 6.00,
                'courier_name' => 'ORIENTE',
                'description' => 'Región oriental (Amazonía)',
            ],
            [
                'code_name' => 'GA',
                'price' => 13.00,
                'courier_name' => 'GALÁPAGOS',
                'description' => 'Islas Galápagos',
            ],
            [
                'code_name' => 'E1',
                'price' => 6.50,
                'courier_name' => 'ESPECIALES 1',
                'description' => 'Zonas especiales 1',
            ],
            [
                'code_name' => 'E2',
                'price' => 7.00,
                'courier_name' => 'ESPECIALES 2',
                'description' => 'Zonas especiales 2',
            ],
        ];

        $this->command->info('Clearing existing shipping prices...');
        ShippingPrice::truncate();

        $this->command->info('Seeding shipping prices...');

        foreach ($prices as $price) {
            ShippingPrice::create($price);
            $this->command->line("  ✓ {$price['code_name']}: {$price['courier_name']} - \${$price['price']}");
        }

        $this->command->info('✓ Successfully seeded ' . count($prices) . ' shipping prices!');
    }
}
