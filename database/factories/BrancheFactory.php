<?php

	namespace Database\Factories;

	use App\Models\Branche;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;

	/**
	 * @extends Factory<\App\Models\Branche>
	 */
	class BrancheFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 * @return array<string, mixed>
		 */
		public function definition()
		{
			return [
				'user_id' => User::factory(),
				'label' => $this->faker->word()
			];
		}
	}
