<?php
	declare(strict_types=1);

	namespace App\Domains\Pool\Actions;

	use App\Domains\Pool\DataObjects\CreatePoolDataObject;
	use App\Models\Pool;
	use DB;

	final class CreatePoolWithTransferor
	{
		public function __invoke(CreatePoolDataObject $payload): void
		{
			//dd($payload);
			DB::transaction(static function () use ($payload) {

				//insertion du pool
				$pool_id = Pool::create([
					'label' => $payload->transferor->raison_social . ' - ' . $payload->year,
					'year' => $payload->year,
					'date_effet' => $payload->date_effet,
					'date_echeance' => $payload->date_echeance,
					'pays_id' => $payload->country->id
				]);

				//insertion du poolables

				foreach ($payload->taux_validates as $key => $data) {
					//dd($payload->activity_rates, $payload->taux_validates);
					$payload->transferor->pools()->attach($pool_id->id, [
						'taux_validate' => $payload->taux_validates[$key],
						'activity_rates_id' => $payload->activity_rates[$key]
					]);
				}


			});

		}
	}