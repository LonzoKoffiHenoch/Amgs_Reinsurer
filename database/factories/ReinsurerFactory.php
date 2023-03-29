<?php

	namespace Database\Factories;

	use App\Models\Reinsurer;
	use Illuminate\Database\Eloquent\Factories\Factory;

	/**
	 * @extends Factory<Reinsurer>
	 */
	class ReinsurerFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 * @return array<string, mixed>
		 */
		public function definition()
		{
			return [
				//
				'raison_social' => $this->faker->company(),
				'r_commerce' => $this->faker->postcode(),
				'd_social' => $this->faker->streetSuffix(),
				'pays' => $this->faker->country(),
			];
		}
	}
