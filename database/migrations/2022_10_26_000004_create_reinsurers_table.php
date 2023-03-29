<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('reinsurers', static function (Blueprint $table) {
				$table->bigIncrements('id');

				$table->string('raison_social');
				$table->string('r_commerce')->nullable();
				$table->string('d_social')->nullable();
				$table->boolean('active')->default(1);

				$table->foreignId('pays_id')->constrained();
				$table->foreignId('user_id')->nullable();

				$table->timestamps();
				$table->softDeletes();
			});
		}


		public function down(): void
		{
			Schema::dropIfExists('reinsurers');
		}
	};
