<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('cities')->count()) {
            return;
        }

        $path = database_path('seeders/sql/philippine_cities.sql');

        if (!file_exists($path)) {
            throw new \Exception("SQL file not found: {$path}");
        }

        DB::unprepared(file_get_contents($path));
    }
}