<?php
	declare(strict_types=1);

	namespace App\Domains\Pool\DataObjects;

	use App\Models\Transferor;
	use Date;
	use Illuminate\Http\Request;

	final class CreatePoolWithReinsurerDataObject implements \App\Contracts\DataObjectContract
	{


		public function __construct(
			public string $year,
			public string $date_effet,
			public string $date_echeance,
			public array  $reinsurers,
			public array  $taux_validate,
			public array  $countries,
			public array  $activity_rates,
		)
		{

		}

		public static function make(Request $request): self
		{
			return new self(

				year: now()->format('Y'),
				date_effet: $request->get('date_effet'),
				date_echeance: $request->get('date_echeance'),
				reinsurers: $request->get('reinsurers'),
				taux_validate: $request->get('validate'),
				countries: $request->get('country'),
				activity_rates: $request->get('activity_rates'),
			);
		}

		public function toArray(): array
		{
			return [];
		}
	}