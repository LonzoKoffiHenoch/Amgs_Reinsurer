<?php

	namespace App\Domains\Businesse\Models;

	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Relations\Pivot;

	final class BusinesseReinsurer extends Pivot
	{
		protected $fillable = [
			'part_accepte', 'commission_reassurance',
			'prime_reassurance', 'ppw',
			'date_accept', 'reinsurer_id',
			'businesse_id', 'statut_payment'
		];

		public function getDateAcceptAttribute($value): string
		{
			return Carbon::parse($value)->format('Y-m-d');
		}
	}
