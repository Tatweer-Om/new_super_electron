<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default user
        User::create([
            'authuser_id' => md5(uniqid()),
            'authuser_name' => 'user',
            'username' => 'admin',
            'password' => Hash::make('1234'),
            'permit_type' => json_encode(range(1, 26)), // Default permissions
        ]);
    }


}
