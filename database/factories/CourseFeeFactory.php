<?php

namespace Database\Factories;

use App\Models\CourseFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFeeFactory extends Factory
{
    protected $model = CourseFee::class;

    public function definition()
    {
        return [
            'course_id' => \App\Models\Course::factory(),
            'amount' => $this->faker->numberBetween(100, 500),
        ];
    }
}