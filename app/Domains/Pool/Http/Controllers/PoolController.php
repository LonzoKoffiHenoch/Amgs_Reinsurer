<?php
	declare(strict_types=1);

	namespace App\Domains\Pool\Http\Controllers;

	use App\Domains\Pool\Actions\CreatePoolWithReinsurer;
	use App\Domains\Pool\Actions\CreatePoolWithTransferor;
	use App\Domains\Pool\DataObjects\CreatePoolDataObject;
	use App\Domains\Pool\DataObjects\CreatePoolWithReinsurerDataObject;
	use App\Http\Controllers\Controller;
	use App\Models\Pays;
	use App\Models\Pool;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;
	use Inertia\Inertia;
	use Inertia\Response;

	final class PoolController extends Controller
	{

		public function index(): Response
		{
			$pools = Pool::all();
			return Inertia::render('Pool/IndexPool', compact('pools'));
		}


		public function create(): Response
		{
			return Inertia::render('Pool/CreatePool', [
				'countries' => Pays::query()->get(['id', 'label']),
				'reinsurers' => Reinsurer::query()->get(['id', 'raison_social', 'pays_id']),
				'transferors' => Transferor::query()->get(['id', 'raison_social', 'pays_id']),
			]);
		}


		public function store(Request $request): RedirectResponse
		{
			//insertion en base du pool et du poolables
			//dd($request);
			(new CreatePoolWithTransferor())(CreatePoolDataObject::make($request));


			return redirect()->back();
		}

		public function storereas(Request $request): RedirectResponse
		{

			(new CreatePoolWithReinsurer())(
				CreatePoolWithReinsurerDataObject::make($request)
			);
			return redirect()->back();

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
		 * Show the form for editing the specified resource.
		 * @param int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}

		/**
		 * Update the specified resource in storage.
		 * @param Request $request
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
	}
