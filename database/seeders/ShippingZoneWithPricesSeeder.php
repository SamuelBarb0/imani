<?php

namespace Database\Seeders;

use App\Models\ShippingPrice;
use App\Models\ShippingZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShippingZoneWithPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the Ecuador zones with prices JSON file
        $jsonPath = database_path('seeders/data/ecuador_zonas_con_precios.json');

        if (!File::exists($jsonPath)) {
            $this->command->error('Ecuador zones with prices JSON file not found at: ' . $jsonPath);
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        if (!$data || !isset($data['Provincias'])) {
            $this->command->error('Failed to parse Ecuador zones JSON file or invalid structure');
            return;
        }

        $this->command->info('Starting to seed shipping prices and zones from Ecuador data...');

        // First, collect all unique price codes with their prices
        $priceCodesMap = [];
        foreach ($data['Provincias'] as $row) {
            $code = $row['Codigo Precio'] ?? null;
            $price = $row['precio'] ?? null;

            if ($code && $price !== null) {
                $priceCodesMap[$code] = $price;
            }
        }

        // Insert unique price codes
        $this->command->info('Creating ' . count($priceCodesMap) . ' unique price codes...');
        foreach ($priceCodesMap as $code => $price) {
            ShippingPrice::updateOrCreate(
                ['code_name' => $code],
                [
                    'price' => $price,
                    'courier_name' => null,
                    'description' => "Código de precio {$code}",
                ]
            );
        }

        $this->command->info('Price codes created successfully!');

        // Now insert zones with their price codes
        $this->command->info('Creating shipping zones...');

        $totalZones = 0;
        $skippedDuplicates = 0;
        $updatedZones = 0;
        $batchSize = 100;
        $batch = [];
        $seenCombinations = [];

        foreach ($data['Provincias'] as $row) {
            $provincia = $row['Provincia'] ?? null;
            $canton = $row['Cantón'] ?? null;
            $parroquia = $row['Parroquia'] ?? null;
            $priceCode = $row['Codigo Precio'] ?? null;

            if (!$provincia || !$canton || !$parroquia) {
                continue;
            }

            // Normalize the data
            $provincia = strtoupper(trim($provincia));
            $canton = strtoupper(trim($canton));
            $parroquia = strtoupper(trim($parroquia));

            // Create unique key to detect duplicates
            $uniqueKey = "{$provincia}|{$canton}|{$parroquia}";

            // Skip if we've already seen this combination in this batch
            if (isset($seenCombinations[$uniqueKey])) {
                $skippedDuplicates++;
                $this->command->warn("Skipping duplicate: {$provincia} > {$canton} > {$parroquia}");
                continue;
            }

            $seenCombinations[$uniqueKey] = true;

            // Try to update existing zone or prepare for insert
            $existingZone = ShippingZone::where('provincia', $provincia)
                ->where('canton', $canton)
                ->where('parroquia', $parroquia)
                ->first();

            if ($existingZone) {
                // Update existing zone with price code
                $existingZone->update(['price_code' => $priceCode]);
                $updatedZones++;
            } else {
                // Add to batch for insert
                $batch[] = [
                    'provincia' => $provincia,
                    'canton' => $canton,
                    'parroquia' => $parroquia,
                    'price_code' => $priceCode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalZones++;
            }

            // Insert in batches for better performance
            if (count($batch) >= $batchSize) {
                DB::table('shipping_zones')->insert($batch);
                $batch = [];
                $this->command->info("Processed {$totalZones} new zones and {$updatedZones} updates so far...");
            }
        }

        // Insert remaining zones
        if (!empty($batch)) {
            DB::table('shipping_zones')->insert($batch);
        }

        $this->command->info("✓ Successfully seeded {$totalZones} new shipping zones!");
        $this->command->info("✓ Updated {$updatedZones} existing zones with price codes!");

        if ($skippedDuplicates > 0) {
            $this->command->warn("⚠ Skipped {$skippedDuplicates} duplicate entries.");
        }

        // Show summary
        $totalPrices = ShippingPrice::count();
        $totalZonesInDb = ShippingZone::count();
        $zonesWithPrices = ShippingZone::whereNotNull('price_code')->count();

        $this->command->info("\n=== SUMMARY ===");
        $this->command->info("Total Price Codes: {$totalPrices}");
        $this->command->info("Total Zones: {$totalZonesInDb}");
        $this->command->info("Zones with Price Codes: {$zonesWithPrices}");
        $this->command->info("Zones without Price Codes: " . ($totalZonesInDb - $zonesWithPrices));
    }
}
