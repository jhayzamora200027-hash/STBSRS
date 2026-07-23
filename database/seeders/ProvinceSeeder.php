<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('provinces')->count()) {
            return;
        }

        $path = database_path('seeders/sql/philippine_provinces.sql');

        if (!file_exists($path)) {
            throw new \Exception("SQL file not found: {$path}");
        }

        DB::unprepared(file_get_contents($path));
    }
}