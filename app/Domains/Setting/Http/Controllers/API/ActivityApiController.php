<?php

	namespace App\Domains\Setting\Http\Controllers\API;

	use App\Http\Controllers\Controller;
	use App\Models\ActivityRate;
	use App\Models\Pays;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use Illuminate\Http\Request;
	use function Pest\Laravel\json;

	final class ActivityApiController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{

		}

		/**
		 * Store a newly created resource in storage.
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Display the specified resource.
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}

		/**
		 * Update the specified resource in storage.
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}

		/**
		 * Remove the specified resource from storage.
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}

		public function getActivityFromTransferor(Request $request, Pays $pays): \Illuminate\Http\JsonResponse
		{
			/*$activities = $transferor->withWhereHas('activityrates', function ($query) use ($transferor, $pays) {
				$query->where('pays_id', $pays->id);
			})->first();*/

			$activities = ActivityRate::query()
				->where('pays_id', '=', $pays->id)
				->where('activity_ratable_type', '=', Reinsurer::class)->get();


			return response()->json(['data' => $activities]);
		}

		public function getActivityFromReinsurer(Request $request, string $pays)
		{

			$data = [];
			$countries = json_decode($pays, false);
			foreach ($countries as $key => $country) {
				$activities = ActivityRate::query()
					->where('pays_id', '=', $country->id)
					->where('activity_ratable_type', '=', Reinsurer::class)->get();

				if (!empty($country)) $data[$country->label] = $activities;
			}
			return response()->json(['data' => $data]);
		}
	}
