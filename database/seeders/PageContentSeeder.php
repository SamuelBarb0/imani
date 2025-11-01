<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Call individual page seeders
        $this->call([
            HomeContentSeeder::class,
            PersonalizadosContentSeeder::class,
            ColeccionesContentSeeder::class,
            ContactoContentSeeder::class,
            MayoristasContentSeeder::class,
        ]);
    }
}
