<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SlipFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'prime_total' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
