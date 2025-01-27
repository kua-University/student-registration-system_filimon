<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'code' => $this->faker->unique()->bothify('??###'),
            'category' => $this->faker->randomElement(['Computer Science', 'Mathematics', 'Chemistry']),
            'credits' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph,
        ];
    }
}
