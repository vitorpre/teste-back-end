<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         if(User::where('email','test@example.com')->first() == null) {
             User::factory()->create([
                 'name' => 'Test User',
                 'email' => 'test@example.com',
                 'password' => bcrypt('password')
             ]);
         }

    }
}
