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

        $startDate = now()->subMonths(12)->startOfMonth();
        $endDate = now()->endOfMonth();

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $numberOfUsers = rand(1, 10); // Random number of users per month

            for ($i = 0; $i < $numberOfUsers; $i++) {
                User::factory()->create(
                    [
                        'created_at' => $startDate,
                        'updated_at' => $startDate,
                    ]
                );
            }

            $startDate->addMonth(); // Move to the next month
        }
    }
}
