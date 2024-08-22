<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin Name',
            'email' => 'admin@gmail.com',
            'phone' => '09111111111',
            'password' => Hash::make(123123123),
        ]);

        Staff::create([
            'name' => 'Staff Name',
            'email' => 'staff@gmail.com',
            'phone' => '09111111111',
            'password' => Hash::make(123123123),
        ]);
    }
}
