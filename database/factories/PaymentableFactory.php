<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PaymentableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'payment_id' => $this->faker->randomNumber(),
            'paymentable_id' => $this->faker->randomNumber(),
            'paymentable_type' => $this->faker->word(),
            'montant_recu' => $this->faker->word(),
            'date_reception' => Carbon::now(),
        ];
    }
}
