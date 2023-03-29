<?php

	namespace App\Domains\Businesse\Models;

	use App\Models\ActivityRate;
	use App\Models\Branche;
	use App\Models\BusinesseLegalTransfert;
	use App\Models\Calculation;
	use App\Models\LegalTransfert;
	use App\Models\Reinsurer;
	use App\Models\Scopes\Searchable;
	use App\Models\Transferor;
	use App\Models\User;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Businesse extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = [
			'nom_assure',
			'date_reception',
			'pays_assure',
			'date_effet',
			'date_echeance',
			'monnaie',
			'capitaux',
			'prime',
			'commission_cedante',
			'part_offerte',
			'prime_a_recevoir',
			'prime_de_reassurance',
			'prime_a_reverser',
			'prime_reçu',
			'montant_recu',
			'montant_reversable',
			'statut',
			'active',
			'user_id',
			'transferor_id',
			'branche_id',
			'slip_id',
			'activity_rate_id'
		];

		protected array $searchableFields = ['*'];

		protected $casts = [
			'date_reception' => 'date',
			'date_effet' => 'date',
			'date_echeance' => 'date',
		];
		protected $with = [
			'transferor',
		];

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function transferor(): BelongsTo
		{
			return $this->belongsTo(Transferor::class);
		}

		public function branche(): BelongsTo
		{
			return $this->belongsTo(Branche::class);
		}

		public function activity_rate(): BelongsTo
		{
			return $this->belongsTo(ActivityRate::class);
		}

		public function reinsurers(): BelongsToMany
		{
			return $this->belongsToMany(Reinsurer::class)->withPivot('part_accepte', 'commission_reassurance', 'prime_reassurance', 'ppw', 'date_accept', 'statut_payment', 'prime_a_reverser');
		}




		// protected function testsum(): Attribute
		// {
		//     // $test = BusinesseReinsurer::all();
		//     // dd($this->businessereinsurer);
		//     return Attribute::make(
		//         get: fn () => $this->reinsurers->sum(
		//             fn (BusinesseReinsurer $businessereinsurer) => $businessereinsurer->prime_reassurance * $businessereinsurer->commission_reassurance

		//         )
		//     );
		// }

		public function getDateReceptionAttribute($value)
		{

			return Carbon::parse($value)->format('Y-m-d');
		}

		public function getDateEffetAttribute($value)
		{

			return Carbon::parse($value)->format('Y-m-d');
		}

		public function getDateEcheanceAttribute($value)
		{

			return Carbon::parse($value)->format('Y-m-d');
		}
	}
