<?php

	use App\Domains\Payment\Http\Controllers\PaymentController;
	use App\Domains\Setting\Http\Controllers\API\ActivityApiController;
	use App\Http\Controllers\DashboardController;
	use App\Http\Controllers\FinanceController;
	use App\Http\Controllers\TransferorController;
	use Illuminate\Support\Facades\Route;
	use Inertia\Inertia;


	Route::get('/', DashboardController::class)->name('home');

	Route::group(["middleware" => "auth"], static function () {

		Route::get('/dashboard', static function () {
			return Inertia::render('Dashboard');
		})->name('dashboard');


		Route::get('/cedente', [TransferorController::class, 'index'])->name('transferor.index');
		Route::post('/cedente/{id}', [TransferorController::class, 'update'])->name('transferor.update');
		Route::delete('/cedente/{id}', [TransferorController::class, 'delete'])->name('transferor.delete');
		Route::get('/cedente/edit/{id}', [TransferorController::class, 'edit'])->name('transferor.edit');
		Route::post('/cedente', [TransferorController::class, 'store'])->name('transferor.store');
		Route::get('/cedente/paiement/', [TransferorController::class, 'paiement'])->name('transferor.paiement');

		Route::get('/finances', [FinanceController::class, 'index'])->name('finance.index')->middleware('permission:finance:show');
		Route::post('/pay', [PaymentController::class, 'store'])->name('paymentsolde.store');
		Route::post('/payreas', [PaymentController::class, 'storepayreas'])->name('paymentsolde.storepayreas');
		Route::get('activities/get/{pays}', [ActivityApiController::class, 'getActivityFromTransferor'])->name('activities.get');
		Route::get('activities/getreas/{pays}', [ActivityApiController::class, 'getActivityFromReinsurer'])->name('activities.getreas');


	});

	Route::get('testing', function () {
		return Inertia::render('Canvas/Index');
	});
	require __DIR__ . '/auth.php';
	require __DIR__ . '/ajax.php';
