<?php

	namespace App\Domains\Setting\Http\Controllers;

	use App\Http\Controllers\Controller;
	use App\Models\Bank;
	use App\Models\Branche;
	use App\Models\Company;
	use App\Models\Pays;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use App\Models\User;
	use Inertia\Inertia;
	use Inertia\Response;
	use Spatie\Permission\Models\Role;

	final class SettingController extends Controller
	{
		public function bank(): Response
		{
			$banks = Bank::whereRelation('bankable', 'bankable_type', Company::class)->get();
			return Inertia::render('Setting/Bank/IndexBank', compact('banks'));
		}

		public function branche(): Response
		{
			$branches = Branche::orderBy('label', 'ASC')->paginate(6);
			return Inertia::render('Setting/Branche/IndexBranche', compact('branches'));
		}

		public function country(): Response
		{
			$countries = Pays::all();
			return Inertia::render('Setting/Country/IndexCountry', compact('countries'));
		}

		public function reinsurer(): Response
		{
			$bank = Bank::all();
			$reas = Reinsurer::orderBy('raison_social', 'ASC')->paginate(7);
			return Inertia::render('Setting/Reinsurer/IndexReinsurer', compact('bank', 'reas'));
		}

		public function transferor(): Response
		{
			$transferors = Transferor::all();
			return Inertia::render('Setting/Transferor/IndexTransferor', compact('transferors'));
		}

		public function role(): Response
		{
			$roles = Role::all();
			return Inertia::render('Setting/Role/IndexRole', compact('roles'));
		}

		public function user(): Response
		{
			$users = User::all();
			return Inertia::render('Setting/User/IndexUser', compact('users'));
		}

		public function activity(): Response
		{
			$pays = Pays::all();
			return Inertia::render('Setting/Activity/UploadActivity', compact('pays'));
		}

	}
