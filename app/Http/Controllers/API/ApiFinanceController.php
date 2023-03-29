<?php

	namespace App\Http\Controllers\API;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Setting\Repositories\CountryRepository;
	use App\Http\Controllers\Controller;
	use App\Http\Resources\FinanceCollection;
	use App\Models\ActivityRate;
	use App\Models\Bank;
	use App\Models\Branche;
	use App\Models\Company;
	use App\Models\Pays;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;

	final class ApiFinanceController extends Controller
	{
		public function getBusinessReq(): JsonResponse
		{
			$affaires = Businesse::where(['active' => '0', 'deleted' => '0'])->with(['reinsurers', 'transferor'])->get();

			return response()->json([
				'affaires' => $affaires
			]);
		}

		public function getReasBusiness(): JsonResponse
		{
			$reas = Reinsurer::withWhereHas('businessesWithNotPay', static function ($query) {
				// pOUR VERIFIER SI LE REAS A été payer totalement ou pas
				$query->where('statut_payment', '<=', '0');
			})->get();
			// dd($reas);
			return response()->json([
				'reas' => $reas
			]);
		}

		public function getTransferor(): FinanceCollection
		{
			$reas = Transferor::with('pays')->whereRelation('businesses', 'statut', '>=', '-1')
				->orWhereRelation('businesses', 'statut', '=', '1')
				->with('businessesWithNotPay')
				->withCount('businessesWithNotPay')
				->paginate(5);

			// return response()->json([
			//     'reas' => $reas
			// ]);

			return new FinanceCollection($reas);
		}

		public function getBranche(): JsonResponse
		{

			return response()->json([
				'branche' => Branche::all()
			]);
		}

		public function getPays(): JsonResponse
		{

			return response()->json([
				'pays' => (new CountryRepository())->getAll()->toArray()
			]);
		}

		public function getBandC(): JsonResponse
		{

			return response()->json([
				'branche' => Branche::all(),
				'cedante' => Transferor::all(),
				'pays' => Pays::all()
			]);
		}

		public function sendbusinesspay(Request $request): JsonResponse
		{
			// dd($request['tab']);
			$test = Businesse::whereIn('id', $request['tab'])->get();
			// dd($test);
			return response()->json(['tab' => $test]);
		}

		public function sendreaspay(Request $request): JsonResponse
		{
			$test = Businesse::whereIn('id', $request['tab'])->with(['reinsurers' => function ($query) use ($request) {
				// dd($request);
				$query->where('reinsurer_id', $request['reasid']);
			}])->get();

			return response()->json(['tab' => $test]);
		}

		public function getBank(Bank $bank): JsonResponse
		{
			// dd($id);
			return response()->json([
				'bank' => $bank
			]);
		}

		public function getAllBank(): JsonResponse
		{
			$banks = Company::where('raison_social', 'AMGS')->with('banks')->firstOrFail();
			return response()->json([
				'banks' => $banks->banks
			]);
		}

		public function getbankreinsurer(Reinsurer $reinsurer): JsonResponse
		{
			// dd($reinsurer);
			return response()->json([
				'reinsurer' => $reinsurer
			]);
		}

		public function getAllTransferor(): JsonResponse
		{
			return response()->json([
				'transferors' => Transferor::with('pays')->get()
			]);
		}

		public function getActivities(): JsonResponse
		{
			return response()->json([
				'activities' => ActivityRate::with('pays')->get()
			]);
		}
	}
