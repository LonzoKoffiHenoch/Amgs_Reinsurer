<?php

	use App\Domains\Setting\Http\Controllers\ActivityController;
	use App\Domains\Setting\Http\Controllers\SettingController;
	use App\Domains\Setting\Http\Controllers\UploadActivityRatesController;
	use App\Http\Controllers\Auth\PasswordController;
	use App\Http\Controllers\BankController;
	use App\Http\Controllers\BrancheController;
	use App\Http\Controllers\CurrencyController;
	use App\Http\Controllers\PaysController;
	use App\Http\Controllers\PermissionController;
	use App\Http\Controllers\ReinsurerController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\TransferorController;
	use App\Http\Controllers\UserController;
	use Illuminate\Support\Facades\Route;

	Route::middleware(['role:superAdmin'])->group(function () {

		Route::get('/setting/bank/', [SettingController::class, 'bank'])->name('setting.bank');
		Route::get('/setting/branche', [SettingController::class, 'branche'])->name('setting.branche');
		Route::get('/setting/transferor', [SettingController::class, 'transferor'])->name('setting.transferor');
		Route::get('/setting/country', [SettingController::class, 'country'])->name('setting.country');
		Route::get('/setting/permission', [SettingController::class, 'permission'])->name('setting.permission');
		Route::get('/setting/reinsurer', [SettingController::class, 'reinsurer'])->name('setting.reinsurer');
		Route::get('/setting/role', [SettingController::class, 'role'])->name('setting.role');
		Route::get('/setting/user', [SettingController::class, 'user'])->name('setting.user');

		Route::post('/setting/bank/', [BankController::class, 'store'])->name('bank.store');
		Route::post('/setting/bank/edit/{bank}', [BankController::class, 'update'])->name('bank.update');
		Route::delete('/setting/bank/{bank}', [BankController::class, 'destroy'])->name('bank.delete');

		Route::post('/setting/branche', [BrancheController::class, 'store'])->name('branche.store');
		Route::get('/setting/branche/edit/{branche}', [BrancheController::class, 'edit'])->name('branche.edit');
		Route::post('/setting/branche/edit/{branche}', [BrancheController::class, 'update'])->name('branche.update');
		Route::delete('/setting/branche/{branche}', [BrancheController::class, 'destroy'])->name('branche.delete');

		Route::post('/setting/country', [PaysController::class, 'store'])->name('country.store');
		Route::get('/setting/country/edit/{pays}', [PaysController::class, 'edit'])->name('country.edit');
		Route::post('/setting/country/edit/{pays}', [PaysController::class, 'update'])->name('country.update');
		Route::delete('/setting/country/{pays}', [PaysController::class, 'destroy'])->name('country.delete');

		Route::post('/setting/permission', [PermissionController::class, 'store'])->name('permission.store');
		Route::get('/setting/permission/edit/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
		Route::post('/setting/permission/edit/{permission}', [PermissionController::class, 'update'])->name('permission.update');
		Route::delete('/setting/permission/{permission}', [PermissionController::class, 'destroy'])->name('permission.delete');


		Route::post('/setting/transferor', [TransferorController::class, 'store'])->name('transferor.store
    .');
		Route::get('/setting/branche/transferor/{transferor}', [BrancheController::class, 'edit'])->name('transferor.edit');
		Route::put('/setting/branche/transferor/{transferor}', [BrancheController::class, 'update'])->name('transferor.update');
		Route::delete('/setting/transferor/{transferor}', [BrancheController::class, 'destroy'])->name('transferor.delete');


		Route::post('/setting/reinsurer', [ReinsurerController::class, 'store'])->name('reas.store');
		Route::get('/setting/reinsurer/create', [ReinsurerController::class, 'create'])->name('reas.create');
		Route::get('/setting/reinsurer/edit/{reinsurer}', [ReinsurerController::class, 'edit'])->name('reas.edit');
		Route::put('/setting/reinsurer/edit/{reinsurer}', [ReinsurerController::class, 'update'])->name('reas.update');
		Route::delete('/setting/reinsurer/{reinsurer}', [ReinsurerController::class, 'destroy'])->name('reas.delete');


		Route::post('/setting/role', [RoleController::class, 'store'])->name('role.store');
		Route::get('/setting/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
		Route::post('/setting/role/edit/{role}', [RoleController::class, 'update'])->name('role.update');
		Route::delete('/setting/role/{role}', [RoleController::class, 'destroy'])->name('role.delete');


		Route::post('/setting/user', [UserController::class, 'store'])->name('user.store');
		Route::get('/setting/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
		Route::post('/setting/user/edit/{user}', [UserController::class, 'update'])->name('user.update');
		Route::delete('/setting/user/{user}', [UserController::class, 'destroy'])->name('user.delete');

		Route::resource('setting/currency', CurrencyController::class);
		Route::prefix('setting')->group(function () {
			Route::get('password', [PasswordController::class, 'index'])->name('setting.password');
			Route::put('password', [PasswordController::class, 'update'])->name('password.update');
		});

		Route::resource('setting/activity', ActivityController::class);
		Route::get('activities', [SettingController::class, 'activity'])->name('setting.activity');
		Route::post('activities', UploadActivityRatesController::class)->name('setting.upload.activity');
	});
