<?php

	namespace Database\Seeders;

	// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	use App\Models\User;
	use Illuminate\Database\Seeder;

	final class DatabaseSeeder extends Seeder
	{
		/**
		 * Seed the application's database.
		 */
		public function run(): void
		{
			User::factory(5)->create();
			//\App\Models\Currency::factory(10)->create();

			// \App\Models\User::factory()->create([
			//     'name' => 'Test User',
			//     'email' => 'test@example.com',
			// ]);
			//ActivityRate::factory(10)->create();
			// \App\Models\Reinsurer::factory(200)->create();
			// \App\Models\Transferor::factory(200)->create();


		}
	}
