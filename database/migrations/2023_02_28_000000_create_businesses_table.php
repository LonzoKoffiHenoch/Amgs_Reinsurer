<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('businesses', static function (Blueprint $table) {

				$table->bigIncrements('id');
				$table->string('nom_assure');
				$table->date('date_reception');
				$table->string('pays_assure');
				$table->date('date_effet');
				$table->date('date_echeance');
				$table->string('monnaie');
				$table->decimal('capitaux', 50, 2);
				$table->decimal('prime', 50, 2);
				$table->decimal('commission_cedante', 50, 2);
				$table->decimal('part_offerte', 50, 2);
				$table->decimal('prime_a_recevoir', 50, 2);
				$table->decimal('prime_de_reassurance', 50, 2);
				$table->decimal('prime_reçu', 50, 2);
				$table->decimal('montant_recu', 50, 2)->nullable();
				$table->decimal('montant_reversable', 50, 2)->nullable();
				$table->tinyInteger('statut')->default(-1);
				$table->tinyInteger('active')->default(1);

				//relationship
				$table->foreignId('user_id')->constrained();
				$table->foreignId('transferor_id')->constrained();
				$table->foreignId('branche_id')->constrained();
				$table->foreignId('slip_id')->nullable()->constrained();
				$table->foreignId('activity_rate_id')->nullable()->constrained();

				$table->timestamps();
				$table->softDeletes();
			});
		}


		public function down(): void
		{
			Schema::dropIfExists('businesses');
		}
	};
