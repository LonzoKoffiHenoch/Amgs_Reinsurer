<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\MorphTo;

	final class ActivityRate extends Model
	{
		use HasFactory;

		protected $fillable = [
			'type',
			'price',
			'pays_id',
			'activity',
			'activity_ratable_type',
			'activity_ratable_id'
		];

		public function pays(): BelongsTo
		{
			return $this->belongsTo(Pays::class, 'pays_id');
		}

		public function activity_ratable(): MorphTo
		{
			return $this->morphTo();
		}
	}
