<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tax;

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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12121212'),
            'role'=>'admin'
        ]);

        Tax::factory()->create([
            'name' => 'IVA',
            'percentage' => 16,
        ]);

        Tax::factory()->create([
            'name' => 'EXENTO',
            'percentage' => 0,
        ]);
    }
}
