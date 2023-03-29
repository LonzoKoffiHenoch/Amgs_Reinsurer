<?php

	namespace Database\Factories;

	use App\Models\Pays;
	use App\Models\Transferor;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;

	/**
	 * @extends Factory<Transferor>
	 */
	class TransferorFactory extends Factory
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

				'pays_id' => Pays::factory(),
				'user_id' => User::factory(),
				'nom' => $this->faker->firstName(),
				'prenom' => $this->faker->lastName(),
			];
		}
	}
