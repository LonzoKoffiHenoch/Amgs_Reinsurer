<?php

	namespace Database\Factories;

	use App\Enums\TypeActivity;
	use Arr;
	use Exception;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;

	final class LegalTransfertFactory extends Factory
	{
		/**
		 * @throws Exception
		 */
		public function definition(): array
		{

			return [
				'type' => Arr::random(TypeActivity::cases()),
				'activity' => $this->faker->word(),
				'price' => $this->faker->randomFloat(2, 1, 100),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'pays_id' => random_int(1, 180),
			];
		}
	}
