<?php

	use App\Domains\Businesse\Http\Controllers\BusinesseController;
	use App\Domains\Businesse\Http\Controllers\UploadBusinesseController;
	use Illuminate\Support\Facades\Route;

	Route::group(["middleware" => "auth"], static function () {
		Route::get('/affaires/upload/', [BusinesseController::class, 'upload'])->name('business.upload');
		Route::post('/affaires/excel/', UploadBusinesseController::class)->name('business.excel');
		Route::get('/affaires', [BusinesseController::class, 'index'])->name('business.index');
		Route::post('/affaires', [BusinesseController::class, 'store'])->name('business.store');
		Route::get('/affaires/edit/{affaires}', [BusinesseController::class, 'edit'])->name('business.edit')->middleware('permission:businesse:edit');
		Route::post('/affaires/{affaire}', [BusinesseController::class, 'update'])->name('businesse.update')->middleware('permission:businesse:edit');
		Route::delete('/affaires/{affaire}', [BusinesseController::class, 'delete'])->name('business.delete')->middleware('permission:businesse:delete');
		Route::get('/test', [BusinesseController::class, 'gettransferor'])->name('business.transferor');
	});


