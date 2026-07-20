<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jay-ar P. Zamora',
            'email' => 'jpzamora@dswd.gov.ph.com',
            'first_name' => 'Jay-ar',
            'middle_name' => 'Patricio',
            'last_name' => 'Zamora',
            'usergroup' => 'sysadmin',
            'password' => Hash::make('123456')
        ]);
    }
}
