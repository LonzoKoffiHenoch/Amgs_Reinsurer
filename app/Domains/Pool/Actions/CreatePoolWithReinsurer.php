<?php
	declare(strict_types=1);

	namespace App\Domains\Pool\Actions;

	use App\Domains\Pool\DataObjects\CreatePoolDataObject;
	use App\Domains\Pool\DataObjects\CreatePoolWithReinsurerDataObject;
	use App\Models\Pool;
	use App\Models\Treaty;
	use DB;

	final class CreatePoolWithReinsurer
	{
		public function __invoke(CreatePoolWithReinsurerDataObject $payload): void
		{
			DB::transaction(static function () use ($payload) {
				$sum = null;

				foreach ($payload->reinsurers as $reas) {
					$sum += $reas['part'];
				}
				//insertion du pool


				//dd($sum);
				//dd($payload);
				foreach ($payload->countries as $country) {

					$pool_id = Pool::create([
						'label' => 'Reassureurs - ' . $payload->year,
						'year' => $payload->year,
						'date_effet' => $payload->date_effet,
						'date_echeance' => $payload->date_echeance,
						'pays_id' => $country['id'],
					]);

					$treaty = Treaty::create([
						'label' => 'Reassureurs - ' . $payload->year,
						'year' => $payload->year,
						'date_effet' => $payload->date_effet,
						'date_echeance' => $payload->date_echeance,
						'total_capicity' => $sum,
						'pays_id' => $country['id'],
					]);

					foreach ($payload->reinsurers as $reinsurer) {
						$treaty->reinsurers()->attach($reinsurer['reinsurer']['id'], [
							'capital' => $reinsurer['part'],
							'part' => $reinsurer['part'] / $sum,

						]);
						//insertion du poolables
						foreach ($payload->taux_validate as $key => $data) {
							$pool_id->reinsurers()->attach($reinsurer['reinsurer']['id'], [
								'capital' => $reinsurer['part'],
								'taux_validate' => $payload->taux_validate[$key],
								'activity_rates_id' => $payload->activity_rates[$key]
							]);
						}
					}

				}


			});

		}
	}