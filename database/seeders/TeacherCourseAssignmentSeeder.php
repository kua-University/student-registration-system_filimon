<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherCourseAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            ['teacher_id' => 5, 'course_id' => 1],
            ['teacher_id' => 5, 'course_id' => 2],
            ['teacher_id' => 6, 'course_id' => 3],
            ['teacher_id' => 6, 'course_id' => 4],
            ['teacher_id' => 7, 'course_id' => 5],
            ['teacher_id' => 7, 'course_id' => 6],
            ['teacher_id' => 5, 'course_id' => 7],
            ['teacher_id' => 6, 'course_id' => 8],
            ['teacher_id' => 7, 'course_id' => 9]
        ];

        DB::table('teacher_course_assignments')->insert($assignments);
    }
}
