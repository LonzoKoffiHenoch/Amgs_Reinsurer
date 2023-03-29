<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;

	final class Calculation extends Model
	{
		use HasFactory;

		protected $fillable = [
			'type',
			'price',
			'capital',
			'prime',
			'businesse_id'
		];

		public function businesse(): BelongsTo
		{
			return $this->belongsTo(\App\Domains\Businesse\Models\Businesse::class);
		}

	}
