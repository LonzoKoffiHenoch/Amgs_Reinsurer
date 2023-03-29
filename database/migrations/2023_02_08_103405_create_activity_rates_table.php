<?php

	use App\Enums\TypeActivity;
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {
		/**
		 * Run the migrations.
		 */
		public function up(): void
		{
			Schema::create('activity_rates', static function (Blueprint $table) {
				$table->id();
				$table->string('type')->default(TypeActivity::VEHICULE->value);
				$table->string('activity');
				$table->decimal('price', 50, 2, true);

				//relationship
				$table->morphs('activity_ratable');
				$table->foreignId('pays_id')->constrained();

				$table->timestamps();
				$table->softDeletes();

			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down(): void
		{
			Schema::dropIfExists('activity_rates');
		}
	};
