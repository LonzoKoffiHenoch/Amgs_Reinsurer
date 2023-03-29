<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('banks', static function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->morphs('bankable');

				$table->string('raison_social');
				$table->string('rib');
				$table->string('num_compte');
				$table->string('code_agence');
				$table->string('code_bank');
				$table->string('devise');
				$table->string('swift');
				$table->string('iban');

				$table->timestamps();
				$table->softDeletes();

				$table->foreignId('user_id')->constrained();
				$table->foreignId('pays_id')->constrained();


			});
		}


		public function down(): void
		{
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
			Schema::dropIfExists('banks');
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		}
	};
