<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;

	final class Treaty extends Model
	{
		//use HasFactory;
		protected $guarded = [];

		public function reinsurers(): belongsToMany
		{
			return $this->belongsToMany(Reinsurer::class)->withPivot(
				'part',
				'capital',
			);
		}
	}
