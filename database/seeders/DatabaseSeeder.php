<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test Admin',
             'email' => 'admin@example.com',
             'user_type' => 'admin',
         ]);

         \App\Models\User::factory()->create([
             'name' => 'Test Customer',
             'email' => 'customer@example.com',
             'user_type' => 'customer',
         ]);
    }
}
