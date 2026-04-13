<?php

namespace Database\Seeders;

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
        // Create admin user only
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
'role' => 'admin', 'email_verified_at' => now(),
        ]);

        // Seed categories and books
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
