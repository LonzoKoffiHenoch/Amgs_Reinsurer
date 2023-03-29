<?php

	namespace App\Domains\Setting\Http\Controllers;

	use App\Domains\Setting\DataObjects\BatimentDataObject;
	use App\Domains\Setting\DataObjects\ConventionActivityDataObject;
	use App\Domains\Setting\DataObjects\VehiculeDataObject;
	use App\Domains\Setting\Http\Requests\ConventionActivityRequest;
	use App\Http\Controllers\Controller;
	use App\Models\ActivityRate;
	use App\Models\Pays;

	use App\Models\Transferor;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;
	use Inertia\Inertia;
	use Inertia\Response;

	final class ActivityController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 * @return \Inertia\Response
		 */
		public function index(): Response
		{
			$activityByTransferor = Transferor::query()
				->withWhereHas('activityrates')
				->withWhereHas('pays')
				->get();
			//dd($activityByTransferor);
			return Inertia::render('Setting/Activity/IndexActivity', compact('activityByTransferor'));
		}

		/**
		 * Store a newly created resource in storage.
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function store(ConventionActivityRequest $request): RedirectResponse
		{
			$dto = (ConventionActivityDataObject::make($request))->toArray();
			foreach ($dto['transferor'] as $transferor) {

				(Transferor::find($transferor['id']))
					->activityrates()
					->create([
						'type' => $dto['type'],
						'activity' => $dto['activity'],
						'price' => $dto['price'],
						'pays_id' => $dto['pays']->id,
					]);


			}
			return redirect()->back();
		}

		/**
		 * Show the form for creating a new resource.
		 * @return \Inertia\Response
		 */
		public function create(): Response
		{
			$data = [
				'vehicule' => (new VehiculeDataObject())->toArray(),
				'batiment' => (new BatimentDataObject())->toArray(),
			];
			$transferors = Transferor::query()->get(['id', 'raison_social', 'pays_id']);
			$countries = Pays::query()->get(['id', 'label',]);
			return Inertia::render('Setting/Activity/CreateActivity', compact('data', 'transferors', 'countries'));

		}

		/**
		 * Display the specified resource.
		 * @param ActivityRate $activityRate
		 * @return \Inertia\Response
		 */
		public function show(ActivityRate $activityRate): Response
		{
			return Inertia::render('Setting/Activity/EditActivity', [
				'$activity' => $activityRate
			]);
		}

		/**
		 * Show the form for editing the specified resource.
		 * @param \App\Models\ActivityRate $activity
		 * @return JsonResponse
		 */
		public function edit(ActivityRate $activity): JsonResponse
		{
			return response()->json(['activity' => $activity]);
		}

		/**
		 * Update the specified resource in storage.
		 * @param \Illuminate\Http\Request $request
		 * @param ActivityRate $activityRate
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function update(Request $request, ActivityRate $activityRate): RedirectResponse
		{
			return redirect()->back();
		}

		/**
		 * Remove the specified resource from storage.
		 * @param \App\Models\ActivityRate $activityRate
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function destroy(ActivityRate $activityRate): RedirectResponse
		{
			return redirect()->back();
		}
	}
