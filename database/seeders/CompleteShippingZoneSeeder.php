<?php

namespace Database\Seeders;

use App\Models\ShippingPrice;
use App\Models\ShippingZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompleteShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Imports all Ecuador provinces, cantons, and parroquias with price codes
     * from the official JSON data file.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/provincias_cantones_parroquias.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("JSON file not found: {$jsonPath}");
            return;
        }

        $jsonContent = file_get_contents($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!isset($data['Provincias']) || !is_array($data['Provincias'])) {
            $this->command->error("Invalid JSON structure. Expected 'Provincias' array.");
            return;
        }

        try {
            // Clear existing data
            $this->command->info('Clearing existing shipping zones...');
            ShippingZone::truncate();

            // Also clear shipping prices if they exist
            if (DB::getSchemaBuilder()->hasTable('shipping_prices')) {
                ShippingPrice::truncate();
            }

            $this->command->info('Importing shipping zones from JSON...');

            // Start transaction after truncate (truncate auto-commits)
            DB::beginTransaction();

            $zonesData = [];
            $processedCount = 0;
            $skippedCount = 0;
            $uniqueKeys = []; // Track unique combinations to avoid duplicates

            foreach ($data['Provincias'] as $item) {
                $provincia = trim($item['Provincia']);
                $canton = trim($item['Cantón']);
                $parroquia = trim($item['Parroquia']);

                // Normalize text for comparison (remove accents, convert to uppercase)
                $normalizeText = function($text) {
                    $text = strtoupper($text);
                    $unwanted_array = array(
                        'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
                        'Ñ'=>'N', 'Ü'=>'U',
                    );
                    return strtr($text, $unwanted_array);
                };

                // Create unique key using normalized text
                $uniqueKey = $normalizeText("{$provincia}|{$canton}|{$parroquia}");

                // Skip duplicates
                if (isset($uniqueKeys[$uniqueKey])) {
                    $skippedCount++;
                    continue;
                }

                $uniqueKeys[$uniqueKey] = true;

                $zonesData[] = [
                    'provincia' => $provincia,
                    'canton' => $canton,
                    'parroquia' => $parroquia,
                    'price_code' => $item['Codigo Precio'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $processedCount++;

                // Insert in batches of 100 for better performance
                // Using smaller batches to reduce memory usage
                if (count($zonesData) >= 100) {
                    DB::table('shipping_zones')->insert($zonesData);
                    $zonesData = [];
                    $this->command->info("Processed {$processedCount} zones...");
                }
            }

            // Insert remaining zones
            if (!empty($zonesData)) {
                DB::table('shipping_zones')->insert($zonesData);
            }

            if ($skippedCount > 0) {
                $this->command->warn("Skipped {$skippedCount} duplicate entries.");
            }

            DB::commit();

            $this->command->info("✓ Successfully imported {$processedCount} shipping zones!");

            // Show summary by province
            $this->command->newLine();
            $this->command->info('Summary by province:');
            $provinces = ShippingZone::select('provincia', DB::raw('count(*) as total'))
                ->groupBy('provincia')
                ->orderBy('provincia')
                ->get();

            foreach ($provinces as $province) {
                $this->command->line("  • {$province->provincia}: {$province->total} zones");
            }

            // Show price code distribution
            $this->command->newLine();
            $this->command->info('Price code distribution:');
            $priceCodes = ShippingZone::select('price_code', DB::raw('count(*) as total'))
                ->groupBy('price_code')
                ->orderBy('price_code')
                ->get();

            foreach ($priceCodes as $code) {
                $priceCode = $code->price_code ?? 'NULL';
                $this->command->line("  • {$priceCode}: {$code->total} zones");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error importing shipping zones: ' . $e->getMessage());
            throw $e;
        }
    }
}
