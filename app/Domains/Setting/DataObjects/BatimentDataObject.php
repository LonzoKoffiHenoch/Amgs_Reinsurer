<?php
	declare(strict_types=1);

	namespace App\Domains\Setting\DataObjects;

	use App\Contracts\DataObjectContract;

	final class BatimentDataObject implements DataObjectContract
	{

		public function toArray(): array
		{
			return [
				'Maison Residentielle',
				'Appartements',
				'Bureaux uniquement',
				'Immeuble commercial',
				'Immeuble commercial non protégé',
				'Hotels, Banques, Assurances',
				'Etablissements industriels avec cloture electrique',
				'Etablissements industriels sans cloture',
				'Centrale Electrique',
				'Telecom',
				'Université, College, Ecoles et autres institutions educatives, Gouvernement',
			];
		}
	}