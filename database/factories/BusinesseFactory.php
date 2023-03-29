<?php

	namespace Database\Factories;

	use App\Models\Branche;
	use App\Models\Slip;
	use App\Models\Transferor;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;

	final class BusinesseFactory extends Factory
	{
		public function definition(): array
		{
			return [
				'nom_assure' => $this->faker->word(),
				'date_reception' => Carbon::now(),
				'pays_assure' => $this->faker->word(),
				'date_effet' => Carbon::now(),
				'date_echeance' => Carbon::now(),
				'monnaie' => $this->faker->word(),
				'capitaux' => $this->faker->randomFloat(),
				'prime' => $this->faker->randomFloat(),
				'commission_cedante' => $this->faker->randomFloat(),
				'part_offerte' => $this->faker->randomFloat(),
				'prime_a_recevoir' => $this->faker->randomFloat(),
				'prime_de_reassurance' => $this->faker->randomFloat(),
				'prime_reçu' => $this->faker->randomFloat(),
				'montant_recu' => $this->faker->randomFloat(),
				'montant_reversable' => $this->faker->randomFloat(),
				'statut' => $this->faker->boolean(),
				'active' => $this->faker->boolean(),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

				'user_id' => User::factory(),
				'transferor_id' => Transferor::factory(),
				'branche_id' => Branche::factory(),
				'slip_id' => Slip::factory(),
			];
		}
	}
