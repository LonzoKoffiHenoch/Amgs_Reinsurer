<?php

	declare(strict_types=1);

	namespace App\Domains\Slip\Actions;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Slip\Http\Requests\SlipUploadRequest;
	use App\Models\BusinesseLegalTransfert;
	use App\Models\Pays;
	use App\Models\Slip;
	use Carbon\Carbon;
	use DB;
	use Exception;

	class UploadSlipAction
	{

		/**
		 * @throws Exception
		 */
		public function __invoke(SlipUploadRequest $request, array $businesses): Slip
		{


			return DB::transaction(static function () use ($request, $businesses) {

				$slip = Slip::create([
					'label' => 'BCP - ' . $request->input('slip')[3][1] . ' - ' . (new Carbon($request->input('date_reception')))->format('d-m-Y'),
					'prime_total' => 100
				]);


				foreach ($businesses as $valueBusinesse) {
					$businesse = Businesse::create(array_merge($valueBusinesse, ['slip_id' => $slip->id]));
					$pays = Pays::query()->where('label', '=', $businesse->pays_assure);
				}
				return $slip;
			});


		}
	}
