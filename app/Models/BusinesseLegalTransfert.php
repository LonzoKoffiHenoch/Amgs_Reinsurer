<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Relations\Pivot;

	class BusinesseLegalTransfert extends Pivot
	{
		protected $fillable = [
			'price', 'capital', 'prime', 'businesse_id', 'legal_transfert_id'
		];

	}
