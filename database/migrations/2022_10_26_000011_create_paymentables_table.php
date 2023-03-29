<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('paymentables', function (Blueprint $table) {

				$table->string('montant_recu');
				$table->date('date_reception');

				$table->foreignId('payment_id')->constrained()->cascadeOnDelete();
				$table->morphs('paymentable');
			});
		}

	
		public function down()
		{
			Schema::dropIfExists('paymentables');
		}
	};
