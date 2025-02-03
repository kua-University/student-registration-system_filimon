<?php

namespace Database\Factories;

use App\Models\RegistrationFee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class RegistrationFeeFactory extends Factory
{
    protected $model = RegistrationFee::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(100, 500),
        ];
    }
}
