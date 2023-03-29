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
			Schema::disableForeignKeyConstraints();
			Schema::create('poolables', function (Blueprint $table) {


				$table->decimal('capacity', 50, 2, true);


				$table->foreignId('pool_id')->constrained()->cascadeOnDelete();
				$table->foreignId('activity_rate')->constrained();
				$table->morphs('poolable');

			});
			Schema::enableForeignKeyConstraints();
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('poolables');
		}
	};
