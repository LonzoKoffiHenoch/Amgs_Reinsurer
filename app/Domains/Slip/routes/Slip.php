<?php

	use App\Domains\Slip\Http\Controllers\ShowTableSlipController;
	use App\Domains\Slip\Http\Controllers\SlipController;
	use App\Domains\Slip\Http\Controllers\UploadSlipController;
	use App\Domains\Slip\Http\Controllers\UploadSlipWithErrorController;
	use Illuminate\Support\Facades\Route;

	Route::group(['middleware' => 'auth'], static function () {
		Route::resource('borderau', SlipController::class, ['names' => 'slip']);
		Route::post('/borderau', UploadSlipController::class)->name('slip.upload');
		Route::get('/borderau/{borderau}/data', ShowTableSlipController::class)->name('slip.showtable');
		Route::post('/borderau/withouterror', UploadSlipWithErrorController::class)->name('slip.uploadwithouterror');

	});
