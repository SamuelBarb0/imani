<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the Ecuador divisions JSON file
        $jsonPath = database_path('seeders/data/ecuador_divisiones.json');

        if (!File::exists($jsonPath)) {
            $this->command->error('Ecuador divisions JSON file not found at: ' . $jsonPath);
            return;
        }

        $ecuadorData = json_decode(File::get($jsonPath), true);

        if (!$ecuadorData) {
            $this->command->error('Failed to parse Ecuador divisions JSON file');
            return;
        }

        $this->command->info('Starting to seed shipping zones from Ecuador geographic data...');

        $totalZones = 0;
        $skippedDuplicates = 0;
        $batchSize = 100;
        $batch = [];
        $seenCombinations = [];

        foreach ($ecuadorData as $provincia => $cantones) {
            foreach ($cantones as $canton => $parroquias) {
                foreach ($parroquias as $parroquia) {
                    // Create unique key to detect duplicates
                    $uniqueKey = strtoupper(trim($provincia)) . '|' . strtoupper(trim($canton)) . '|' . strtoupper(trim($parroquia));

                    // Skip if we've already seen this combination
                    if (isset($seenCombinations[$uniqueKey])) {
                        $skippedDuplicates++;
                        $this->command->warn("Skipping duplicate: {$provincia} > {$canton} > {$parroquia}");
                        continue;
                    }

                    $seenCombinations[$uniqueKey] = true;

                    $batch[] = [
                        'provincia' => $provincia,
                        'canton' => $canton,
                        'parroquia' => $parroquia,
                        'price_code' => null, // Will be assigned by admin later
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $totalZones++;

                    // Insert in batches for better performance
                    if (count($batch) >= $batchSize) {
                        ShippingZone::insert($batch);
                        $batch = [];
                        $this->command->info("Inserted {$totalZones} zones so far...");
                    }
                }
            }
        }

        // Insert remaining zones
        if (!empty($batch)) {
            ShippingZone::insert($batch);
        }

        $this->command->info("Successfully seeded {$totalZones} shipping zones from Ecuador!");

        if ($skippedDuplicates > 0) {
            $this->command->warn("Skipped {$skippedDuplicates} duplicate entries.");
        }
    }
}
