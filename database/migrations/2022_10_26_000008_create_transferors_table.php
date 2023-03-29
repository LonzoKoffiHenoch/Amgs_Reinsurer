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
			Schema::create('transferors', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('raison_social');
				$table->string('r_commerce')->nullable();
				$table->string('d_social')->nullable();
				$table->string('nom')->nullable();
				$table->string('prenom')->nullable();

				//relationship
				$table->foreignId('pays_id')->constrained();
				$table->foreignId('user_id')->constrained();
				$table->timestamps();
				$table->softDeletes();
			});
		}

		/**
		 * Reverse the migrations.
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('transferors');
		}
	};
