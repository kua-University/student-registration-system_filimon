<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentCourseEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = [
            ['student_id' => 2, 'course_id' => 1, 'status' => 'approved'],
            ['student_id' => 2, 'course_id' => 2, 'status' => 'completed'],
            ['student_id' => 2, 'course_id' => 6, 'status' => 'pending'],
            ['student_id' => 2, 'course_id' => 9, 'status' => 'approved'],
            ['student_id' => 3, 'course_id' => 1, 'status' => 'pending'],
            ['student_id' => 3, 'course_id' => 3, 'status' => 'approved'],
            ['student_id' => 3, 'course_id' => 7, 'status' => 'approved'],
            ['student_id' => 4, 'course_id' => 4, 'status' => 'approved'],
            ['student_id' => 4, 'course_id' => 5, 'status' => 'completed'],
            ['student_id' => 4, 'course_id' => 8, 'status' => 'completed'],

        ];

        DB::table('student_course_enrollments')->insert($enrollments);
    }
}
