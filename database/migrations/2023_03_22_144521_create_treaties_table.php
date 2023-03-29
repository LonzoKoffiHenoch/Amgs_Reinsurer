<?php

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
			Schema::create('treaties', function (Blueprint $table) {
				$table->id();
				$table->string('label');
				$table->date('year');
				$table->date('date_effet');
				$table->date('date_echeance');
				$table->decimal('total_capicity');
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('treaties');
		}
	};
