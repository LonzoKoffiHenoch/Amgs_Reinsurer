<?php

	namespace App\Models;

	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\MorphTo;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Bank extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = [
			'bankable_id',
			'bankable_type',
			'user_id',
			'pays_id',
			'raison_social',
			'rib',
			'num_compte',
			'code_agence',
			'code_bank',
			'devise',
			'swift',
			'iban',
		];
		protected $with = ['pays'];

		protected array $searchableFields = ['*'];

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function bankable(): MorphTo
		{
			return $this->morphTo();
		}

		public function pays(): BelongsTo
		{
			return $this->belongsTo(Pays::class);
		}
	}
