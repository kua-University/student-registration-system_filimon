<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            ['student_id' => 2, 'amount' => 500.00, 'payment_type' => 'registration', 'course_id' => null, 'status' => 'completed'],
            ['student_id' => 2, 'amount' => 1500.00, 'payment_type' => 'course_enrollment', 'course_id' => 1, 'status' => 'completed'],
            ['student_id' => 2, 'amount' => 1200.00, 'payment_type' => 'course_enrollment', 'course_id' => 2, 'status' => 'completed'],
            ['student_id' => 2, 'amount' => 1300.00, 'payment_type' => 'course_enrollment', 'course_id' => 9, 'status' => 'completed'],
            ['student_id' => 3, 'amount' => 500.00, 'payment_type' => 'registration', 'course_id' => null, 'status' => 'completed'],
            ['student_id' => 3, 'amount' => 1800.00, 'payment_type' => 'course_enrollment', 'course_id' => 3, 'status' => 'completed'],
            ['student_id' => 3, 'amount' => 1900.00, 'payment_type' => 'course_enrollment', 'course_id' => 7, 'status' => 'completed'],
            ['student_id' => 4, 'amount' => 500.00, 'payment_type' => 'registration', 'course_id' => null, 'status' => 'completed'],
            ['student_id' => 4, 'amount' => 2000.00, 'payment_type' => 'course_enrollment', 'course_id' => 4, 'status' => 'completed'],
            ['student_id' => 4, 'amount' => 1600.00, 'payment_type' => 'course_enrollment', 'course_id' => 5, 'status' => 'completed'],
            ['student_id' => 4, 'amount' => 1700.00, 'payment_type' => 'course_enrollment', 'course_id' => 8, 'status' => 'completed'],
            
            
        ];

        DB::table('payments')->insert($payments);
    }
}
