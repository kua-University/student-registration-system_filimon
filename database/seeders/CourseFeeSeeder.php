<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['course_id' => 1, 'amount' => 1500.00],
            ['course_id' => 2, 'amount' => 1200.00],
            ['course_id' => 3, 'amount' => 1800.00],
            ['course_id' => 4, 'amount' => 2000.00],
            ['course_id' => 5, 'amount' => 1600.00],
            ['course_id' => 6, 'amount' => 1400.00],
            ['course_id' => 7, 'amount' => 1900.00],
            ['course_id' => 8, 'amount' => 1700.00],
            ['course_id' => 9, 'amount' => 1300.00],
        ];

        DB::table('course_fees')->insert($fees);
    }
}
