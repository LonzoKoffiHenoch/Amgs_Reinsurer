<?php

	namespace Database\Factories;

	use App\Models\Currency;
	use Illuminate\Database\Eloquent\Factories\Factory;

	/**
	 * @extends Factory<\App\Models\Currency>
	 */
	class CurrencyFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 * @return array<string, mixed>
		 */
		public function definition()
		{
			return [
				'label' => fake()->currencyName(),
				'code' => fake()->currencyCode(),

			];
		}
	}
