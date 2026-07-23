<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RegionSeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\ProgramSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'jpzamora@dswd.gov.ph'],
            [
                'name' => 'Jay-ar P. Zamora',
                'first_name' => 'Jay-ar',
                'middle_name' => 'Patricio',
                'last_name' => 'Zamora',
                'usergroup' => 'sysadmin',
                'password' => Hash::make('123456'),
            ]
        );

        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            ProgramSeeder::class
        ]);
    }
}