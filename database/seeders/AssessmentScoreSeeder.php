<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scores = [
            ['student_id' => 2, 'assessment_id' => 1, 'score' => 35.50],
            ['student_id' => 2, 'assessment_id' => 2, 'score' => 92.00],
            ['student_id' => 2, 'assessment_id' => 4, 'score' => 45.00],
            ['student_id' => 2, 'assessment_id' => 5, 'score' => 77.50],
            ['student_id' => 2, 'assessment_id' => 6, 'score' => 92.00],
            ['student_id' => 2, 'assessment_id' => 22, 'score' => 35.50],
            ['student_id' => 2, 'assessment_id' => 23, 'score' => 92.00],
            ['student_id' => 3, 'assessment_id' => 7, 'score' => 60.00],
            ['student_id' => 3, 'assessment_id' => 8, 'score' => 45.50],
            ['student_id' => 3, 'assessment_id' => 18, 'score' => 88.00],
            ['student_id' => 4, 'assessment_id' => 10, 'score' => 88.50],
            ['student_id' => 4, 'assessment_id' => 12, 'score' => 20.00],
            ['student_id' => 4, 'assessment_id' => 13, 'score' => 17.00],
            ['student_id' => 4, 'assessment_id' => 14, 'score' => 90.00],
            ['student_id' => 4, 'assessment_id' => 15, 'score' => 87.00],
            ['student_id' => 4, 'assessment_id' => 20, 'score' => 135.00],
            ['student_id' => 4, 'assessment_id' => 21, 'score' => 90.00],
        ];

        DB::table('assessment_scores')->insert($scores);
    }
}
