<?php

	use App\Enums\TypeCession;
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up()
		{
			Schema::create('legal_transferts', static function (Blueprint $table) {
				$table->id();
				$table->string('type')->default(TypeCession::CLF->value);

				$table->foreignId('reinsurer_id')->constrained();
				$table->timestamps();
			});
		}


		public function down()
		{
			Schema::dropIfExists('legal_transferts');
		}
	};
