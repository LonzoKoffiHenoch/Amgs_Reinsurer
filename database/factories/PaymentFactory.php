<?php

	namespace Database\Factories;

	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;

	final class PaymentFactory extends Factory
	{
		public function definition(): array
		{
			return [
				'bank_id' => $this->faker->randomNumber(),
				'entresortie' => $this->faker->boolean(),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

				'user_id' => User::factory(),
			];
		}
	}
