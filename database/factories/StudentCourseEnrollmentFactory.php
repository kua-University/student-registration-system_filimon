<?php

namespace Database\Factories;

use App\Models\StudentCourseEnrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentCourseEnrollmentFactory extends Factory
{
    protected $model = StudentCourseEnrollment::class;

    public function definition()
    {
        return [
            'student_id' => User::factory()->create(['role' => 'student'])->id,
            'course_id' => Course::factory()->create()->id,
            'status' => $this->faker->randomElement(['pending', 'approved', 'completed']),
        ];
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
        ]);
    }

    public function approved()
    {
        return $this->state([
            'status' => 'approved',
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }
}