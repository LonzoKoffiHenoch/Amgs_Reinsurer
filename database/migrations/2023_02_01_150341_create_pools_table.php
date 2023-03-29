<?php

	use App\Enums\TypeActivity;
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {
		/**
		 * Run the migrations.
		 * @return void
		 */
		public function up()
		{
			Schema::create('pools', function (Blueprint $table) {
				$table->id();
				$table->string('label');

				$table->date('year');
				$table->date('date_effet');
				$table->date('date_echeance');
				$table->enum('type', [TypeActivity::VEHICULE->value, TypeActivity::BATIMENT->value]);
				$table->decimal('total_capacity', 50, 2, true);

				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('pools');
		}
	};
