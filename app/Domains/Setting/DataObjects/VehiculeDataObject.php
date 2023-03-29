<?php
	declare(strict_types=1);

	namespace App\Domains\Setting\DataObjects;

	use App\Contracts\DataObjectContract;

	final class VehiculeDataObject implements DataObjectContract
	{

		public function toArray(): array
		{
			return [
				'Ordinaire',
				'Hotels, Banques, Assurances',
				'Telecom',
				'Université, College, Ecoles et autres institutions educatives, Gouvernement',
			];
		}
	}