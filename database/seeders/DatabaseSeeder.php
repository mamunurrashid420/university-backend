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
            'name' => 'AIFT Admin',
            'email' => 'admin@aift.edu.bd',
            'password' => Hash::make('a1fT#2026@'),
        ]);

        $this->call([
            DepartmentSeeder::class,
            ProgramSeeder::class,
            SemesterSeeder::class,
        ]);
    }
}
