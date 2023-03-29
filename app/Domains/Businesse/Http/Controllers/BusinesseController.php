<?php

	namespace App\Domains\Businesse\Http\Controllers;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Businesse\Models\BusinesseReinsurer;
	use App\Http\Controllers\Controller;
	use App\Models\Pays;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;
	use Illuminate\Support\Arr;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Str;
	use Inertia\Inertia;
	use Inertia\Response;


	class BusinesseController extends Controller
	{

		final public function index(Request $request): Response
		{
			$search = $request->search ?? null;
			$per_page = $request->per_page ?? null;

			$affaires = Businesse::when($search, static function ($query) use ($search) {
				$query->where("nom_assure", "like", "%$search%");
				// $query->orWhere("prenom", "like", "%${search}%");
			})->where('active', '1')->with(['reinsurers', 'transferor'])
				->withSum('reinsurers', (DB::raw('businesse_reinsurer.prime_a_reverser')))
				->orderBy('nom_assure', 'ASC')->latest()->paginate($per_page ?? 20);

			return Inertia::render('Business/IndexBusiness', ([
				'reinsurer' => Arr::pluck(Reinsurer::orderBy('raison_social')->get('raison_social'), 'raison_social'),
				'affaires' => $affaires,
				'pays' => Pays::get(['label', 'id'])->toJson(),
				'cedante' => Transferor::get(['raison_social', 'pays_id'])->toJson(),
				"filtres" => $request->all("search", "per_page")
			]));
		}


		final public function store(Request $request): RedirectResponse
		{
			$req = Transferor::where('raison_social', $request->input('transferors_id')['raison_social'])->get('id');
			$val = [
				'transferor_id' => $req[0]['id'],
				'branche_id' => $request['branche']['id'],
				'nom_assure' => $request['nom_assure'],
				'date_reception' => $request['date_reception'],
				'pays_assure' => $request['pays_assure']['label'],
				'date_effet' => $request['date_effet'],
				'date_echeance' => $request['date_echeance'],
				'monnaie' => $request['monnaie'],
				'capitaux' => $request['capitaux'],
				'prime' => $request['prime'],
				'commission_cedante' => $request['commission_cedante'],
				'part_offerte' => $request['part_offerte'],
				'prime_a_recevoir' => ($request['prime'] * $request['part_offerte']) * (1 - ($request['commission_cedante'] / 100)),
				'prime_de_reassurance' => ($request['prime'] * $request['part_offerte']),
				'prime_reçu' => (int)$request['prime'] * (int)$request['part_offerte'],
				'user_id' => auth()->user()->id
			];

			$Businesse = Businesse::create($val);
			foreach ($request->input('reinsurer') as $bus) {
				if (!empty($bus['raison_social'])) {
					$reinsurer = Reinsurer::where("raison_social", $bus['raison_social'])->get();
					$bus['reinsurer_id'] = $reinsurer[0]['id'];
					$bus['businesse_id'] = $Businesse->id;
					BusinesseReinsurer::create($bus);
				}
			}
			return redirect()->back();
		}

		final public function edit(Businesse $affaires): Response
		{
			$cedante = Transferor::all();
			$reqResponse = DB::table('businesse_reinsurer')
				->join('Businesses', 'Businesses.id', '=', 'businesse_reinsurer.Businesse_id')
				->join('reinsurers', 'reinsurers.id', '=', 'businesse_reinsurer.reinsurer_id')
				->where('businesse_reinsurer.Businesse_id', $affaires['id'])->get()->toArray();
			$request = (Businesse::where('id', $affaires->id)->with(['reinsurers', 'branche'])->get());

			//Arr flatten associe un tableau multi en associatif
			$reas = Arr::flatten(Reinsurer::get('raison_social')->toArray());
			return Inertia::render('Business/EditBusiness', [
				'reinsurer' => $reqResponse,
				'cedante' => $cedante,
				'reas' => $reas,
				'affaires' => $request[0]
			]);
		}

		final public function upload(): Response
		{
			return Inertia::render('Business/UploadForm');
		}

		final public function delete(Businesse $affaire): redirectResponse
		{
			$affaire['active'] = 1;
			$affaire->update();
			$affaire->delete();

			return redirect()->back();
		}

		final public function update(Request $request, Businesse $affaire): redirectResponse
		{
			$val = [
				'transferor_id' => $request['transferor_id'],
				'branche_id' => $request['branche']['id'],
				'nom_assure' => $request['nom_assure'],
				'date_reception' => $request['date_reception'],
				'pays_assure' => is_array($request['pays_assure']) ? Str::upper($request['pays_assure']['label']) : Str::upper($request['pays_assure']),
				'date_effet' => $request['date_effet'],
				'date_echeance' => $request['date_echeance'],
				'monnaie' => $request['monnaie'],
				'capitaux' => $request['capitaux'],
				'prime' => $request['prime'],
				'commission_cedante' => $request['commission_cedante'],
				'part_offerte' => $request['part_offerte'],
				'prime_a_recevoir' => ($request['prime'] * $request['part_offerte']) * (1 - ($request['commission_cedante'] / 100)),
				'prime_de_reassurance' => ($request['prime'] * $request['part_offerte']),
				'prime_reçu' => (int)($request['prime'] * $request['part_offerte']) * (1 - ($request['commission_cedante'] / 100)),
				'montant_recu' => $affaire->montant_recu ?? 0,
				'montant_reversable' => $affaire->montant_reversable ?? 0,

			];
			$affaire->update($val);

			$test = [];
			foreach ($request->input('reinsurer') as $bus) {
				if (!empty($bus['raison_social'])) {
					$reinsurer = Reinsurer::where("raison_social", $bus['raison_social'])->get('id');
					$unset = [
						"id", "active", "created_by", "deleted_at", "created_at", "updated_at", "transferor_id", "branche_id", "nom_assure", "date_reception", "pays_assure", "date_effet", "date_echeance", "monnaie",
						"capitaux", "prime", "commission_cedante", "part_offerte", "prime_a_recevoir", "prime_de_reassurance", "prime_reçu", "statut", "deleted_by", "raison_social", "r_commerce", "d_social", "pays", "montant_recu", "montant_reversable", "user_id"
					];
					foreach ($unset as $value) {
						unset($bus[$value]);
					}
					$bus['reinsurer_id'] = $reinsurer[0]['id'];
					$test[$bus['reinsurer_id']] = $bus;
				}
			}
			$affaire->reinsurers()->sync($test);

			return redirect()->route('business.index');
		}
	}
