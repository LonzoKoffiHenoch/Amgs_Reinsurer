<?php

	namespace App\Models;

	use Carbon\Traits\Timestamp;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\MorphToMany;

	final class Pool extends Model
	{
		use HasFactory;
		use Timestamp;

		protected $guarded = [];

		public function transferors(): MorphToMany
		{
			return $this->morphedByMany(Transferor::class, 'poolable')->withPivot('taux_validate', 'activity_rates_id');
		}

		public function reinsurers(): MorphToMany
		{
			return $this->morphedByMany(Reinsurer::class, 'poolable')->withPivot('activity_rates_id', 'taux_validate', 'capital');
		}
	}
