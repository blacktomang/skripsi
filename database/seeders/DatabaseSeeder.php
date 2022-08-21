<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(30)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 1,
            'phone_number' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => '$2a$12$Pa8NCjgo6rFJfl7M/9OQw.gbA.ldeHrH97HaNxim0/k5kNiGRrJu6', // password
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);
    }
}
