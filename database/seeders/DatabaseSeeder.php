<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Call individual seeders for the different tables
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            CourseFeeSeeder::class,
            RegistrationFeeSeeder::class,
            TeacherCourseAssignmentSeeder::class,
            CourseAssessmentSeeder::class,
            AssessmentScoreSeeder::class,
            PaymentSeeder::class,
            StudentCourseEnrollmentSeeder::class,
        ]);
    }
}
