<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('businesse_reinsurer', static function (Blueprint $table) {
				$table->foreignId('reinsurer_id')->constrained()->cascadeOnDelete();
				$table->foreignId('businesse_id')->constrained()->cascadeOnDelete();

				$table->decimal('part_accepte', 50, 2);
				$table->decimal('commission_reassurance', 50, 2);
				$table->decimal('prime_reassurance', 50, 2);
				$table->decimal('ppw', 50, 2);
				$table->date('date_accept');
				$table->decimal('prime_a_reverser', 50, 2)->nullable();
				$table->decimal('montant_reverser', 50, 2)->nullable();
				$table->decimal('montant_possible_reverse', 50, 2)->nullable();
				$table->tinyInteger('statut_payment')->default(-1);


			});
		}

		public function down(): void
		{
			Schema::dropIfExists('businesse_reinsurer');
		}
	};
