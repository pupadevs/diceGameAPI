<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::create([
           'name' => 'Admin',
           'email' => 'admin@example.com',
           'email_verified_at' => now(),
           'password' => env('ADMIN_PASSWORD', '12345678'), // password
           'remember_token' => Str::random(10),

        ])->assignRole('admin');

        User::create([
            'name' => 'player',
            'email' => 'player@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt(12345678), // password
            'remember_token' => Str::random(10),

         ])->assignRole('player');
    }
}
