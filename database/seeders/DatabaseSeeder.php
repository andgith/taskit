<?php

namespace Database\Seeders;

use App\Models\Task;
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
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@taskit.test',
            'password' => bcrypt('password'),
        ]);

        // Create 4 incomplete tasks
        $user->tasks()->create([
            'title' => 'Complete Report for Q1',
            'description' => 'Prepare and submit the quarterly report for the first quarter.',
            'due_date' => now()->addDays(7),
            'priority' => 2,
            'completed_at' => null,
        ]);

        $user->tasks()->create([
            'title' => 'Meeting with Client',
            'description' => 'Discuss project updates and address any concerns with the client.',
            'due_date' => now()->addDays(3),
            'priority' => 1,
            'completed_at' => null,
        ]);

        $user->tasks()->create([
            'title' => 'Prepare Presentation Slides',
            'description' => 'Create slides for the upcoming team meeting presentation.',
            'due_date' => now()->addDays(2),
            'priority' => 4,
            'pinned' => true,
            'completed_at' => null,
        ]);

        $user->tasks()->create([
            'title' => 'Research New Marketing Strategies',
            'description' => 'Explore and gather information on the latest marketing trends and strategies.',
            'due_date' => null,
            'priority' => 3,
            'completed_at' => null,
        ]);

        // Create 2 complete tasks
        $user->tasks()->create([
            'title' => 'Follow-up Email to Client',
            'description' => 'Send a follow-up email to the client regarding the project status.',
            'due_date' => now()->subDays(2),
            'priority' => 4,
            'completed_at' => now(),
        ]);

        $user->tasks()->create([
            'title' => 'Review Project Documentation',
            'description' => 'Review and finalize project documentation for the upcoming release.',
            'due_date' => now()->subDays(5),
            'priority' => 4,
            'completed_at' => now(),
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
