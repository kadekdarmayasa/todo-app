<?php

namespace Database\Seeders;

use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $johnDoe = User::where('email', 'johndoe@example.com')->first();
        $janeDoe = User::where('email', 'janedoe@example.com')->first();
        $aliceSmith = User::where('email', 'alicesmith@example.com')->first();


        /**
         * John Doe's tasks
         */
        $johnDoe->tasks()->createMany([
            [
                'title' => 'Buy groceries',
                'description' => 'Milk, Bread, Eggs, Butter',
                'priority' => PriorityEnum::Low->value,
                'status' => StatusEnum::Pending->value,
                'due_date' => Carbon::now()->format('Y-m-d')
            ],
            [
                'title' => 'Finish project report',
                'description' => 'Complete the final report for the project',
                'priority' => PriorityEnum::High->value,
                'status' => StatusEnum::InProgress->value,
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d')
            ]
        ]);


        /**
         * Jane Doe's tasks
         */
        $janeDoe->tasks()->createMany([
            [
                'title' => 'Call the bank',
                'description' => 'Inquire about the new credit card offers',
                'priority' => PriorityEnum::Medium->value,
                'status' => StatusEnum::Pending->value,
                'due_date' => Carbon::now()->addDays(2)->format('Y-m-d')
            ],
            [
                'title' => 'Schedule dentist appointment',
                'description' => 'Routine check-up and cleaning',
                'priority' => PriorityEnum::Low->value,
                'status' => StatusEnum::Completed->value,
                'due_date' => Carbon::now()->subDays(3)->format('Y-m-d')
            ]
        ]);

        /**
         * Alice Smith's tasks
         */
        $aliceSmith->tasks()->createMany([
            [
                'title' => 'Plan weekend trip',
                'description' => 'Research destinations and book accommodations',
                'priority' => PriorityEnum::Medium->value,
                'status' => StatusEnum::InProgress->value,
                'due_date' => Carbon::now()->addDays(7)->format('Y-m-d')
            ],
            [
                'title' => 'Organize clothes donation',
                'description' => 'Sort clothes and donate unused items',
                'priority' => PriorityEnum::Low->value,
                'status' => StatusEnum::Pending->value,
                'due_date' => Carbon::now()->addDays(10)->format('Y-m-d')
            ]
        ]);

        $this->command->info('Tasks seeded successfully.');
    }
}
