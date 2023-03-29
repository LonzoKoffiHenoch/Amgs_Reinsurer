<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('businesse_legal_transfert', static function (Blueprint $table) {

				$table->decimal('price', 3, 2);
				$table->decimal('capital', 50, 2);
				$table->decimal('prime', 50, 2);

				$table->foreignId('businesse_id')->constrained();
				$table->foreignId('legal_transfert_id')->constrained();

			});
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('businesse_legal_transfert');
		}
	};
