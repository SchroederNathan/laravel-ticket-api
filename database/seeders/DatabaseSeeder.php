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
        $users = User::factory(10)->create();

        \App\Models\Ticket::factory(100)
            ->recycle($users)
            ->create();


            \App\Models\User::create([
                'email' => 'manager@example.com',
                'name' => 'The Manager',
                'password' => bcrypt('password'),
                'is_manager' => true,
            ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
