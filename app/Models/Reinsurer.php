<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Payment\Models\Payment;
	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Database\Eloquent\Relations\MorphMany;
	use Illuminate\Database\Eloquent\Relations\MorphToMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Reinsurer extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = [
			'raison_social',
			'r_commerce',
			'd_social',
			'pays',
			'active',
			'user_id',
		];

		protected array $searchableFields = ['*'];

		protected $casts = [
			'active' => 'boolean',
		];
		protected $with = [
			'banks',
		];

		public function user(): belongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function businesses(): belongsToMany
		{
			return $this->belongsToMany(Businesse::class)->withPivot(
				'part_accepte',
				'commission_reassurance',
				'prime_reassurance',
				'ppw',
				'date_accept',
				'reinsurer_id',
				'businesse_id',
				'statut_payment',
				'prime_a_reverser'
			);
		}

		public function businessesWithNotPay(): belongsToMany
		{
			return $this->belongsToMany(Businesse::class)->where('statut', '>=', '0')->withPivot(
				'part_accepte',
				'commission_reassurance',
				'prime_reassurance',
				'ppw',
				'date_accept',
				'reinsurer_id',
				'businesse_id',
				'statut_payment',
				'prime_a_reverser'
			);
		}

		public function banks(): morphMany
		{
			return $this->morphMany(Bank::class, 'bankable');
		}

		public function payments(): morphToMany
		{
			return $this->morphToMany(Payment::class, 'paymentable');
		}

		public function pools(): morphToMany
		{
			return $this->morphToMany(Pool::class, 'poolable');
		}

		public function activityrates(): MorphMany
		{
			return $this->morphMany(ActivityRate::class, 'activity_ratable');
		}

		public function treaties(): belongsToMany
		{
			return $this->belongsToMany(Treaty::class)->withPivot(
				'part',
				'capital',

			);
		}

	}
