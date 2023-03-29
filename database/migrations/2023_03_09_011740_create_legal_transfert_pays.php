<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('legal_transfert_pays', static function (Blueprint $table) {
				$table->decimal('price', 5, 2);


				$table->foreignId('legal_transfert_id')->constrained()->cascadeOnDelete();
				$table->foreignId('pays_id')->constrained()->cascadeOnDelete();

			});
		}


		public function down(): void
		{
			Schema::dropIfExists('pays_legal_transfert');
		}
	};
