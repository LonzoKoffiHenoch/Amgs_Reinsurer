<?php

	namespace App\Domains\Setting\Http\Controllers;

	use App\Domains\Setting\DataObjects\UploadActivitiesDataObject;
	use App\Http\Controllers\Controller;
	use App\Models\ActivityRate;
	use App\Models\Transferor;
	use DB;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;


	class UploadActivityRatesController extends Controller
	{

		public function __invoke(Request $request): RedirectResponse
		{

			$data = (new UploadActivitiesDataObject(
				type: $request->input('activity'),
				pays: $request->input('pays'),
				data: $request->input('values'),
				activity_ratable_type: Transferor::class,
				activity_ratable_id: 89
			))->toArray();


			DB::transaction(static function () use ($data) {
				foreach ($data['data'] as $activity) {
					foreach ($data['pays'] as $pays) {
						if (empty($pays)) continue;
						$ok = ActivityRate::create([
							'type' => $data['type'],
							'activity' => $activity[0],
							'price' => round($activity[1], 2),
							'activity_ratable_type' => $data['activity_ratable_type'],
							'activity_ratable_id' => $data['activity_ratable_id'],
							'pays_id' => $pays['id']
						]);

					}
				}

			});
			return redirect()->back();
		}
	}
