<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Payment\Models\Payment;
	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\Relations\MorphMany;
	use Illuminate\Database\Eloquent\Relations\MorphToMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Transferor extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = ['pays_id', 'user_id'];

		protected array $searchableFields = ['*'];


		public function pays(): belongsTo
		{
			return $this->belongsTo(Pays::class);
		}

		public function user(): belongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function businesses(): hasMany
		{
			return $this->hasMany(Businesse::class);
		}

		public function payments(): morphToMany
		{
			return $this->morphToMany(Payment::class, 'paymentable');
		}

		public function pools(): morphToMany
		{
			return $this->morphToMany(Pool::class, 'poolable')->withPivot('taux_validate', 'activity_rates_id');
		}

		public function activityrates(): MorphMany
		{
			return $this->morphMany(ActivityRate::class, 'activity_ratable');
		}


		public function businessesWithNotPay(): hasMany
		{
			return $this->hasMany(Businesse::class)->where('statut', '<=', '0');
		}
	}
