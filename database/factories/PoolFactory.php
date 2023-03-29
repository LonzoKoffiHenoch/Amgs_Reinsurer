<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PoolFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'year' => Carbon::now(),
            'total_capacity' => $this->faker->randomFloat(),
            'type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
