<?php
	declare(strict_types=1);

	namespace App\Domains\Pool\DataObjects;

	use App\Models\Pays;
	use App\Models\Transferor;
	use Date;
	use Illuminate\Http\Request;

	final class CreatePoolDataObject implements \App\Contracts\DataObjectContract
	{


		public function __construct(
			public string          $year,
			public string          $date_effet,
			public string          $date_echeance,
			public Transferor|null $transferor,
			public Pays|null       $country,
			public array           $taux_validates,
			public array           $activity_rates,
		)
		{

		}

		public static function make(Request $request): self
		{
			return new self(
				year: (new \DateTime($request->get('date_effet')))->format('Y'),
				date_effet: $request->get('date_effet'),
				date_echeance: $request->get('date_echeance'),
				transferor: Transferor::find($request->get('transferor')['id']),
				country: Pays::query()->find($request->get('country')['id']),
				taux_validates: $request->get('validate'),
				activity_rates: $request->get('activity_rates'),

			);
		}

		public function toArray(): array
		{
			return [];
		}
	}