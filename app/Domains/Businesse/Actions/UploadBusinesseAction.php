<?php

	declare(strict_types=1);

	namespace App\Domains\Businesse\Actions;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Businesse\Models\BusinesseReinsurer;
	use App\Models\Branche;
	use App\Models\Reinsurer;
	use App\Models\Transferor;
	use DateTime;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Str;


	class UploadBusinesseAction
	{
		public function __invoke(Request $request): void
		{
			DB::transaction(static function () use ($request) {
				foreach ($request->input('excel') as $k => $value) {
					if ($k < 1) continue;

					//Vérifie si dans le fichier Excell la colone nom_assure n'est pas vide
					if ((Businesse::where('nom_assure', $value[0])->get())->isNotEmpty()) {

						//recupère le réassureur
						$reinsurer = Reinsurer::where("raison_social", $value[13])->get();
						$Businesse = Businesse::where("nom_assure", $value[0])->get();

						//insertion dans la table pivot
						BusinesseReinsurer::create([
							'part_accepte' => round($value[15] * 100, 2),
							'commission_reassurance' => round($value[16] * 100, 2),
							'prime_reassurance' => $value[17],
							'prime_reçu' => $value[18],
							'ppw' => $value[19],
							'date_accept' => new DateTime($value[20]),
							'reinsurer_id' => $reinsurer[0]['id'],
							'businesse_id' => $Businesse[0]['id'],
						]);
					} else {
						
						$te = Str::upper($value[3]);
						$req = Transferor::where('raison_social', (string)$te)->get('id');
						$branche = Branche::where('label', $value[4])->get('id');

						$val = [
							'transferor_id' => $req[0]['id'] ?? $req['id'],
							'nom_assure' => $value[0],
							'date_reception' => new DateTime($value[1]),
							'pays_assure' => $value[2],
							'branche_id' => $branche[0]['id'],
							'date_effet' => new DateTime($value[5]),
							'date_echeance' => new DateTime($value[6]),
							'monnaie' => $value[7],
							'capitaux' => $value[8],
							'prime' => $value[9],
							'commission_cedante' => round($value[10] * 100, 2),
							'part_offerte' => round($value[11] * 100, 2),
							'prime_a_recevoir' => (($value[9] * $value[11]) * (1 - ($value[10]))),
							'prime_de_reassurance' => ($value[9] * $value[11]),
							'prime_reçu' => (($value[9] * $value[11]) * (1 - ($value[10]))),
							'user_id' => auth()->user()->id,
						];

						$Businesse = Businesse::create($val);
						if (Reinsurer::where("raison_social", Str::upper($value[13]))->get()->isNotEmpty()) {
							$reinsurer = Reinsurer::where("raison_social", Str::upper($value[13]))->get();
							BusinesseReinsurer::create([
								'part_accepte' => round($value[15] * 100, 2),
								'commission_reassurance' => round($value[16] * 100, 2),
								'prime_reassurance' => $value[17],
								'prime_reçu' => $value[18],
								'ppw' => $value[19],
								'date_accept' => new DateTime($value[20]),
								'reinsurer_id' => $reinsurer[0]['id'],
								'businesse_id' => $Businesse->id,
							]);
						}
					}
				}
			});
		}
	}
