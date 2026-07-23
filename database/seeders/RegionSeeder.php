<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/sql/philippine_regions.sql');

        if (!DB::table('regions')->count()) {
            DB::unprepared(file_get_contents($path));
        }
    }
}