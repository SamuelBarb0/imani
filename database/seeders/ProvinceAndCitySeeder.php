<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceAndCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds all 24 provinces of Ecuador with their capitals
     */
    public function run(): void
    {
        $provincesAndCities = [
            ['province' => 'Azuay', 'capital' => 'Cuenca'],
            ['province' => 'Bolívar', 'capital' => 'Guaranda'],
            ['province' => 'Cañar', 'capital' => 'Azogues'],
            ['province' => 'Carchi', 'capital' => 'Tulcán'],
            ['province' => 'Chimborazo', 'capital' => 'Riobamba'],
            ['province' => 'Cotopaxi', 'capital' => 'Latacunga'],
            ['province' => 'El Oro', 'capital' => 'Machala'],
            ['province' => 'Esmeraldas', 'capital' => 'Esmeraldas'],
            ['province' => 'Galápagos', 'capital' => 'Puerto Baquerizo Moreno'],
            ['province' => 'Guayas', 'capital' => 'Guayaquil'],
            ['province' => 'Imbabura', 'capital' => 'Ibarra'],
            ['province' => 'Loja', 'capital' => 'Loja'],
            ['province' => 'Los Ríos', 'capital' => 'Babahoyo'],
            ['province' => 'Manabí', 'capital' => 'Portoviejo'],
            ['province' => 'Morona Santiago', 'capital' => 'Macas'],
            ['province' => 'Napo', 'capital' => 'Tena'],
            ['province' => 'Orellana', 'capital' => 'Francisco de Orellana'],
            ['province' => 'Pastaza', 'capital' => 'Puyo'],
            ['province' => 'Pichincha', 'capital' => 'Quito'],
            ['province' => 'Santa Elena', 'capital' => 'Santa Elena'],
            ['province' => 'Santo Domingo de los Tsáchilas', 'capital' => 'Santo Domingo'],
            ['province' => 'Sucumbíos', 'capital' => 'Nueva Loja'],
            ['province' => 'Tungurahua', 'capital' => 'Ambato'],
            ['province' => 'Zamora Chinchipe', 'capital' => 'Zamora'],
        ];

        foreach ($provincesAndCities as $data) {
            // Create province
            $province = Province::create([
                'name' => $data['province'],
                'is_active' => true,
            ]);

            // Create capital city for this province
            City::create([
                'name' => $data['capital'],
                'province_id' => $province->id,
                'is_active' => true,
            ]);

            $this->command->info("✓ Provincia '{$province->name}' creada con su capital '{$data['capital']}'");
        }

        $this->command->info("\n✅ Se crearon " . count($provincesAndCities) . " provincias con sus capitales.");
    }
}
