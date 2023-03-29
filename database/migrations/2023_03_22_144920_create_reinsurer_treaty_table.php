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
			Schema::create('reinsurer_treaty', function (Blueprint $table) {
				$table->id();
				$table->foreignId('reinsurer_id')->constrained();
				$table->foreignId('treaty_id')->constrained();
				$table->foreignId('pays_id')->constrained();
				$table->decimal('capital', 50, 3);
				$table->decimal('part', 10, 3);
			});
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('reinsurer_treaty');
		}
	};
