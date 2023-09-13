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
         User::insert([
             [
             'name' => 'First Admin',
             'email' => 'admin@example.com',
             'user_type' => 'admin',
             'status' => 'active',
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
             [
             'name' => 'First Customer',
             'email' => 'customer@example.com',
             'user_type' => 'customer',
             'status' => 'active',
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
         ]);
    }
}
