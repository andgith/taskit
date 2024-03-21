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
        User::factory()->hasTasks(4)->create([
            'name' => 'Test User',
            'email' => 'test@taskit.test',
            'password' => bcrypt('password'),
        ]);
    }
}
