<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        // Prefer agency2.csv if present (contains full dataset), fallback to agency.csv
        $path1 = database_path('seeders/data/agency2.csv');
        $path2 = database_path('seeders/data/agency.csv');

        if (file_exists($path1)) {
            $file = $path1;
        } elseif (file_exists($path2)) {
            $file = $path2;
        } else {
            $this->command->error('agency CSV not found.');
            return;
        }

        $this->command->info('Using file: ' . $file);

        DB::table('agency')->truncate();

        $handle = fopen($file, 'r');

        // Skip the header row
        fgetcsv($handle);

        while (($row = fgetcsv($handle, 10000, ",")) !== false) {

            // Skip deleted records
            if ((int)$row[11] === 1) {
                continue;
            }

            $groupCode = trim($row[1]);
            $groupName = trim($row[2]);

            $rawDirectorate = trim($row[6]);
            $directorateCode = $rawDirectorate;

            if (is_numeric($rawDirectorate)) {
                $region = DB::table('regions')->where('id', (int)$rawDirectorate)->first();
                if ($region && isset($region->region_code)) {
                    $directorateCode = $region->region_code;
                }
            }

            try {
                static $used = [];

                $insertCode = $groupCode;
                $suffix = 1;

                while (DB::table('agency')->where('group_code', $insertCode)->exists() || isset($used[$insertCode])) {
                    $suffix++;
                    $insertCode = $groupCode . '-' . $suffix;
                }

                DB::table('agency')->insert([
                    'group_code'       => $insertCode,
                    'group_name'       => $groupName,
                    'directorate_code' => $directorateCode,
                    'status'           => 'active',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                $used[$insertCode] = true;
            } catch (\Throwable $e) {
                $this->command->error("Failed inserting agency {$groupCode}: " . $e->getMessage());
            }
        }

        fclose($handle);

        $this->command->info('Agency table seeded successfully.');
    }
}