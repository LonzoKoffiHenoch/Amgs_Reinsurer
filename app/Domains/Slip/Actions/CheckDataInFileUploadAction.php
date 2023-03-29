<?php

	namespace App\Domains\Slip\Actions;

	use App\Domains\Slip\Http\Requests\SlipUploadRequest;
	use App\Models\Pays;
	use App\Models\Transferor;
	use Arr;
	use Exception;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;

	class CheckDataInFileUploadAction
	{
		/**
		 * @throws Exception
		 */
		final public function handle(SlipUploadRequest $request): Request|RedirectResponse
		{
			$errors = [];

			foreach ($request->input('slip') as $keyDataRequest => $dataRequest) {

				if ($keyDataRequest < 6 || $dataRequest[0] === null) continue;
				//dd(strtoupper($dataRequest[0]));


				$getPaysId = Pays::where('label', '=', strtoupper($dataRequest[0]))->firstOrFail()->getKey();
				//dd($dataRequest[1] . ' - ' . (new \DateTime($dataRequest[6]))->format('Y'));
				$getAc = Transferor::query()
					->where('raison_social', strtoupper($dataRequest[1]))
					->withWhereHas('pools', function ($query) use ($dataRequest, $getPaysId) {
						$query->where([
							'pays_id' => $getPaysId,
							'label' => $dataRequest[1] . ' - ' . (new \DateTime($dataRequest[6]))->format('Y'),
							// 'activity' => $dataRequest[3]
						]);
					})
					->first()
					?->getAttribute('pools')
					->first();
				//dd($getAc);
				$priceActivity = $getAc?->getAttribute('price');
				if ($getAc) {
					$getPricePoolTransferor = Transferor::query()
						->where('raison_social', strtoupper($dataRequest[1]))
						->withWhereHas('pools', function ($query) use ($getAc) {
							$query->where('activity_rates_id', $getAc->id);
						});

				} else {
					throw new Exception("nous n'avons pas de convention avec " . strtoupper($dataRequest[1]) . " en " . (new \DateTime($dataRequest[6]))->format('Y'));
				}

				//dd($getAc);

				if ($priceActivity) {
					//voir si prime/capitaux >= au prix des activités en fonction de la cédante
					$normalizeLine = $keyDataRequest + 2;
					if (round(($dataRequest[11] / $dataRequest[10]) * 100, 2) < (float)$priceActivity) $errors["ligne_$normalizeLine"]['taux_conventionés'] = "taux conventionnés";

					//Verification Cession Légale => CICA RE || SEN RE => Fonctionnel du Pays
					if (!($dataRequest[13] / $dataRequest[12] === (float)$dataRequest[10])) $errors["ligne_$normalizeLine"]['capital_CICA'] = "capital";
					if (!(round($dataRequest[14] / $dataRequest[12], precision: 1) === (float)$dataRequest[11])) $errors["ligne_$normalizeLine"]['prime_CICA'] = "prime";

					//Verification Conservation Cédante
					if ($dataRequest[15] !== 0) {
						if (!($dataRequest[16] / $dataRequest[15] === (float)$dataRequest[10])) $errors["ligne_$normalizeLine"]['capital_cedante'] = "le capital conservation";
						if (!(round($dataRequest[17] / $dataRequest[15], precision: 1) === (float)$dataRequest[11])) $errors["ligne_$normalizeLine"]['prime_cedante'] = "prime de la conservation ";
					} else {
						$errors["ligne_$normalizeLine"]['prime_cedante'] = "Conservation Cedante est 0 ";
					}


					//Verification  CICA RE Fact
					if (!($dataRequest[19] / $dataRequest[18] === (float)$dataRequest[10])) $errors["ligne_$normalizeLine"]['capital_cica_fact'] = "capital CICA RE Fact";
					if (!(round($dataRequest[20] / $dataRequest[18], precision: 1) === (float)$dataRequest[11])) $errors["ligne_$normalizeLine"]['prime_cica_fact'] = "prime CICA RE Fact";

					//Verification  POOL PVT
					if (!(round($dataRequest[22] / $dataRequest[21], 1) === (float)$dataRequest[10])) $errors["ligne_$normalizeLine"]['capital_wpvt'] = "capital POOL WPVT";
					if (!(round($dataRequest[23] / $dataRequest[21], precision: 1) === (float)$dataRequest[11])) $errors["ligne_$normalizeLine"]['prime_wpvt'] = "prime POOL WPVT";

					if (!empty($errors["ligne_$normalizeLine"])) $errors["ligne_$normalizeLine"] =
						"<tr class='text-red-700 text-left'><td>Affaire $dataRequest[4] - N° Police $dataRequest[5] erreur : </td></tr><tr tr class='text-left'><td>"
						. Arr::join($errors["ligne_$normalizeLine"], ", ")
						. "<hr class='mb-2'></td></tr>";
				}


			}

			if (!empty($errors)) {
				$concatLine = Arr::join($errors, " ") . "<hr class='mb-2'>";

				return throw new Exception("<table class='text-sm table-auto'> $concatLine </table> ", 500);
			}

			return $request;
		}
	}