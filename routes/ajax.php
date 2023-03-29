<?php

	use App\Domains\Setting\Http\Controllers\API\ActivityApiController;
	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\API\ApiFinanceController;
	use App\Http\Controllers\API\ApiSlipController;

	Route::middleware('auth')->group(function () {
		// requête Ajax
		Route::get('/reassureurs', [ApiFinanceController::class, 'getTransferor'])->name('api.reas');
		Route::get('/businesse', [ApiFinanceController::class, 'getBusinessReq'])->name('business.get');
		Route::get('/reinsurerget', [ApiFinanceController::class, 'getReasBusiness'])->name('api.reasbus');
		Route::get('/allbranche', [ApiFinanceController::class, 'getBranche'])->name('api.getBranche');
		Route::get('/allpays', [ApiFinanceController::class, 'getPays'])->name('api.getPays');
		Route::get('/getBandC', [ApiFinanceController::class, 'getBandC'])->name('api.getBandC');
		Route::post('/sendbusinesspay', [ApiFinanceController::class, 'sendbusinesspay'])->name('send.businesspay');
		Route::post('/sendreaspay', [ApiFinanceController::class, 'sendreaspay'])->name('send.reaspay');
		Route::get('/getalltransferor', [ApiFinanceController::class, 'getAllTransferor'])->name('api.getAllTransferor');
		Route::get('/getactivities', [ApiFinanceController::class, 'getActivities'])->name("api.getActivities");

		Route::get('/setting/bank/edit/{bank}', [ApiFinanceController::class, 'getBank'])->name('api.getBank');
		Route::get('/setting/getbankreinsurer/{reinsurer}', [ApiFinanceController::class, 'getbankreinsurer'])->name('api.get_bank_for_reinsurer');

		Route::get('/setting/Allbank', [ApiFinanceController::class, 'getAllBank'])->name('api.getAllBank');

		Route::apiResource('apiSlip', ApiSlipController::class)->only('index');

		Route::apiResource('activities', ActivityApiController::class);
	});
