<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Ayşe Demir',
            'email' => 'ayse@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Mehmet Kaya',
            'email' => 'mehmet@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
} 