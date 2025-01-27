<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'student_id' => \App\Models\User::factory(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'payment_type' => $this->faker->randomElement(['registration', 'course_enrollment']),
            'payment_intent_id' => 'pi_' . $this->faker->unique()->uuid,
            'status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
        ];
    }

    public function completed()
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function registration()
    {
        return $this->state([
            'payment_type' => 'registration',
        ]);
    }

    public function course_enrollment()
    {
        return $this->state([
            'payment_type' => 'course_enrollment',
        ]);
    }
}