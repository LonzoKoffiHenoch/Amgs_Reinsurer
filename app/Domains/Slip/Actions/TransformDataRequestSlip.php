<?php

	declare(strict_types=1);

	namespace App\Domains\Slip\Actions;

	use App\Domains\Slip\Http\Requests\SlipUploadRequest;
	use App\Models\ActivityRate;
	use App\Models\Branche;
	use App\Models\Pays;
	use App\Models\Transferor;
	use DateTime;
	use Exception;

	class TransformDataRequestSlip
	{
		/**
		 * @throws Exception
		 */
		public function __invoke(SlipUploadRequest $request): array
		{
			//dd($request);
			$normalizeData = [];
			foreach ($request->input('slip') as $keyDataRequest => $dataRequest) {

				if ($keyDataRequest < 6 || $dataRequest[0] === null) {
					continue;
				}

				$getTransferorId = Transferor::query()
					->where('raison_social', strtoupper($dataRequest[1]))
					->firstOrFail();

				$getPaysID = Pays::where('label', '=', $dataRequest[0])->firstOrFail()->getKey('id');

				$priceID = ActivityRate::query()->where([
					'activity' => $dataRequest[3],
					'type' => $dataRequest[2],
				])->whereHasMorph('activity_ratable', [Transferor::class], function ($query) {
					$query->where('id', 113);
				})->firstOrFail()->getKey();
				//->where([
				//	'pays_id' => Pays::where('label', '=', $dataRequest[0])->firstOrFail()->getKey('id'),
				//	'type' => $dataRequest[2],
				//	'activity' => $dataRequest[3]
				//])
				//->firstOrFail()
				//->getAttribute('id');

				$normalizeData[] = [
					'user_id' => auth()->user()->id,
					'activity_rate_id' => $priceID,
					'transferor_id' => $getTransferorId->id,
					'nom_assure' => $dataRequest[4],
					'date_reception' => new DateTime($request['date_reception']),
					'pays_assure' => $dataRequest[0],
					'branche_id' => Branche::query()->where('label', 'VIOLENCES POLITIQUES')->first('id')?->getKey('id'),
					'date_effet' => new DateTime($dataRequest[6]),
					'date_echeance' => new DateTime($dataRequest[7]),
					'monnaie' => $dataRequest[8],
					'capitaux' => $dataRequest[10],
					'prime' => $dataRequest[11],
					'commission_cedante' => round($dataRequest[15] * 100, 2),
					'part_offerte' => round($dataRequest[18] * 100, 2),
					'prime_a_recevoir' => (($dataRequest[11] * $dataRequest[18]) * (1 - ($dataRequest[15]))),
					'prime_de_reassurance' => ($dataRequest[11] * $dataRequest[18]),
					'prime_reçu' => (($dataRequest[11] * $dataRequest[18]) * (1 - ($dataRequest[15]))),
				];

			}
			return $normalizeData;
		}
	}
