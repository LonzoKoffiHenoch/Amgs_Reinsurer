<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {

		public function up(): void
		{
			Schema::create('users', static function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
				$table->string('username');
				$table->string('email')->unique();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password');
				$table->string('remember_token', 100)->nullable();

				$table->timestamps();
				$table->softDeletes();
			});
		}


		public function down(): void
		{
			Schema::dropIfExists('users');
		}
	};
