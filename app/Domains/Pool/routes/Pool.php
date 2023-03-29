<?php

	use App\Domains\Pool\Http\Controllers\PoolController;
	use Illuminate\Support\Facades\Route;


	Route::group(["middleware" => "auth"], static function () {
		Route::Resource('pool', PoolController::class);
		Route::post('pool/createreas', [PoolController::class, 'storereas'])->name('pool.storereas');
	});
