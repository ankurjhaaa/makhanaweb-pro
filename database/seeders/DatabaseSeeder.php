<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Agar default user chahiye to uncomment karo
        /*
        \App\Models\User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        // Yahan apne custom seeders call karo
        $this->call([
            // CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
