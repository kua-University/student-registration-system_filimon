<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assessments = [
            ['course_id' => 1, 'assessment_name' => 'Homework Assignments', 'max_score' => 50, 'weight' => 0.30],
            ['course_id' => 1, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.30],
            ['course_id' => 1, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 2, 'assessment_name' => 'Quizzes', 'max_score' => 50, 'weight' => 0.20],
            ['course_id' => 2, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 2, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 3, 'assessment_name' => 'Homework Assignments', 'max_score' => 75, 'weight' => 0.20],
            ['course_id' => 3, 'assessment_name' => 'Quizzes', 'max_score' => 50, 'weight' => 0.30],
            ['course_id' => 3, 'assessment_name' => 'Final Project', 'max_score' => 100, 'weight' => 0.50],
            ['course_id' => 4, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 4, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.60],
            ['course_id' => 5, 'assessment_name' => 'Homework 1', 'max_score' => 25, 'weight' => 0.15],
            ['course_id' => 5, 'assessment_name' => 'Homework 2', 'max_score' => 25, 'weight' => 0.15],
            ['course_id' => 5, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.35],
            ['course_id' => 5, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.35],
            ['course_id' => 6, 'assessment_name' => 'Lab Assignments', 'max_score' => 150, 'weight' => 0.60],
            ['course_id' => 6, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 7, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.50],
            ['course_id' => 7, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.50],
            ['course_id' => 8, 'assessment_name' => 'Essays', 'max_score' => 150, 'weight' => 0.75],
            ['course_id' => 8, 'assessment_name' => 'Final Paper', 'max_score' => 100, 'weight' => 0.25],
            ['course_id' => 9, 'assessment_name' => 'Midterm Exam', 'max_score' => 100, 'weight' => 0.40],
            ['course_id' => 9, 'assessment_name' => 'Final Exam', 'max_score' => 100, 'weight' => 0.60],
            
        ];

        DB::table('course_assessments')->insert($assessments);
    }
}
