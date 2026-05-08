<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Admin default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@company.com',
            'no_sap' => 'SAP001',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        // Generate 10 fake users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'no_sap' => 'SAP' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'role' => $faker->randomElement(['manager', 'manager']),
                'status' => $faker->randomElement(['active', 'inactive']),
                'password' => Hash::make('password123'),
            ]);
        }
    }
}