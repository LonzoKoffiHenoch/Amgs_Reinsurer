<?php

	namespace App\Domains\Payment\Models;

	use App\Models\Reinsurer;
	use App\Models\Scopes\Searchable;
	use App\Models\Transferor;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\MorphToMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Payment extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = ['user_id', 'bank_id'];

		protected array $searchableFields = ['*'];

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}

		public function transferors(): MorphToMany
		{
			return $this->morphedByMany(Transferor::class, 'paymentable');
		}

		public function reinsurers(): MorphToMany
		{
			return $this->morphedByMany(Reinsurer::class, 'paymentable');
		}
	}
