<?php

	namespace App\Http\Controllers;

	use App\Models\Pays;
	use App\Models\Reinsurer;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;
	use Inertia\Inertia;

	class ReinsurerController extends Controller
	{

		public function index()
		{
		}

		/**
		 * Store a newly created resource in storage.
		 * @param Request $request
		 * @return Response
		 */
		public function store(Request $request)
		{
			// dd($requ est->banks);
			$reinsurer = request()->user()->reinsurers()->create([
				'raison_social' => $request->raison_social,
				'r_commerce' => $request->r_commerce,
				'd_social' => $request->d_social,
				'pays' => $request->pays['label']
			]);
			foreach ($request->banks as $bank) {
				// dd($bank);
				isset($bank['user_id'])
					? ''
					: $bank['user_id'] = request()->user()->id;
				$bank['pays_id'] = $bank['pays_id']['id'];
				// unset($bank['pays']);
				$reinsurer->banks()->updateOrCreate(['id' => isset($bank['id']) ? $bank['id'] : ''], $bank);
			}

			return redirect()->route('setting.reinsurer');
		}

		public function create()
		{
			$pays = Pays::get(['label', 'id']);
			return Inertia::render('Setting/Reinsurer/CreateReinsurer', compact('pays'));
		}

		public function edit(Reinsurer $reinsurer)
		{

			// dd($reinsurer);
			return Inertia('Setting/Reinsurer/EditReinsurer', [
				'reinsurer' => $reinsurer,
				'pays' => Pays::get(['label', 'id'])
			]);
		}

		public function update(Request $request, Reinsurer $reinsurer)
		{
			// dd($request);
			$reinsurer->update([
				'raison_social' => $request->raison_social,
				'r_commerce' => $request->r_commerce,
				'd_social' => $request->d_social,
				'pays' => is_array($request->pays) ? $request->pays['label'] : $request->pays
			]);

			foreach ($request->banks as $bank) {
				// dd();
				isset($bank['user_id'])
					? ''
					: $bank['user_id'] = request()->user()->id;
				$bank['pays_id'] = $bank['pays']['id'];
				unset($bank['pays']);
				$reinsurer->banks()->updateOrCreate(['id' => isset($bank['id']) ? $bank['id'] : ''], $bank);
			}

			return redirect()->route('setting.reinsurer');
		}

		public function destroy(Reinsurer $reinsurer)
		{
			$reinsurer->delete();
		}
	}
