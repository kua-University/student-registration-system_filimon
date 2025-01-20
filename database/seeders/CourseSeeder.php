<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'Introduction to Programming', 'code' => 'CS101', 'category' => 'Computer Science', 'credits' => 3, 'description' => 'A foundational course in programming.'],
            ['name' => 'Calculus I', 'code' => 'MA101', 'category' => 'Mathematics', 'credits' => 4, 'description' => 'Introduction to differential and integral calculus.'],
            ['name' => 'Linear Algebra', 'code' => 'MA201', 'category' => 'Mathematics', 'credits' => 3, 'description' => 'Study of vector spaces and linear transformations.'],
            ['name' => 'Data Structures and Algorithms', 'code' => 'CS201', 'category' => 'Computer Science', 'credits' => 4, 'description' => 'Advanced data structures and algorithms.'],
            ['name' => 'Database Systems', 'code' => 'CS301', 'category' => 'Computer Science', 'credits' => 3, 'description' => 'Design and implementation of database systems.'],
            ['name' => 'Introduction to Physics', 'code' => 'PH101', 'category' => 'Physics', 'credits' => 4, 'description' => 'Fundamental concepts in physics.'],
            ['name' => 'Organic Chemistry', 'code' => 'CH201', 'category' => 'Chemistry', 'credits' => 3, 'description' => 'Study of carbon-containing compounds.'],
            ['name' => 'English Composition', 'code' => 'EN101', 'category' => 'English', 'credits' => 3, 'description' => 'Fundamentals of writing and composition.'],
            ['name' => 'Introduction to Psychology', 'code' => 'PS101', 'category' => 'Psychology', 'credits' => 3, 'description' => 'Fundamental principles of psychology.'],
        ];

        DB::table('courses')->insert($courses);
    }
}
