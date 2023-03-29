<?php

	namespace Database\Factories;

	use App\Models\Pays;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;

	final class BankFactory extends Factory
	{
		public function definition(): array
		{
			return [
				'bankable_id' => $this->faker->randomNumber(),
				'bankable_type' => $this->faker->word(),
				'raison_social' => $this->faker->word(),
				'rib' => $this->faker->word(),
				'num_compte' => $this->faker->word(),
				'code_agence' => $this->faker->word(),
				'code_bank' => $this->faker->word(),
				'devise' => $this->faker->word(),
				'swift' => $this->faker->word(),
				'iban' => $this->faker->word(),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

				'user_id' => User::factory(),
				'pays_id' => Pays::factory(),
			];
		}
	}
