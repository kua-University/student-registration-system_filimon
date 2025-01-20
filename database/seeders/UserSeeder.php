<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('admin123'), 'role' => 'admin'],
            ['name' => 'Student 1', 'email' => 'student1@example.com', 'password' => Hash::make('student123'), 'role' => 'student'],
            ['name' => 'Student 2', 'email' => 'student2@example.com', 'password' => Hash::make('student123'), 'role' => 'student'],
            ['name' => 'Student 3', 'email' => 'student3@example.com', 'password' => Hash::make('student123'), 'role' => 'student'],
            ['name' => 'Teacher 1', 'email' => 'teacher1@example.com', 'password' => Hash::make('teacher123'), 'role' => 'teacher'],
            ['name' => 'Teacher 2', 'email' => 'teacher2@example.com', 'password' => Hash::make('teacher123'), 'role' => 'teacher'],
            ['name' => 'Teacher 3', 'email' => 'teacher3@example.com', 'password' => Hash::make('teacher123'), 'role' => 'teacher'],
        ];

        DB::table('users')->insert($users);
    }
}
