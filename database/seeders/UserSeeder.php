<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com', // Set a unique email for the admin user
            'name' => 'Admin User', // Set the name for the admin user
            'password' => '1234' // Set the password for the admin user
        ]);
        User::factory()->maintainer()->create([
            'email' => 'maintainer@example.com', // Set a unique email for the maintainer user
            'name' => 'maintainer User', // Set the name for the maintainer user
            'password' => '1234' // Set the password for the maintainer user
        ]);
        User::factory(10)->create(); // Create 10 users
    }
}
