<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => env('ADMIN_NAME'),
            'password' => env('ADMIN_PASSWORD'),
        ]);

        Property::factory(50)->create();
    }
}
