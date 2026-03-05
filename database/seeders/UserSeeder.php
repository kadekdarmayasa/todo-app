<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /**
        * Data users dummy
        *
        * @var array<int, array<string, string>>
        */
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('johndoe123')
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'password' => bcrypt('janedoe123')
            ],
            [
                'name' => 'Alice Smith',
                'email' => 'alicesmith@example.com',
                'password' => bcrypt('alicesmith123')
            ]
        ];

        User::insert($users);

        $this->command->info('Users seeded successfully.');
    }
}
