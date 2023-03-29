<?php

	namespace App\Models;

	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Pays extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = ['label'];

		protected $searchableFields = ['*'];

		public function transferors(): HasMany
		{
			return $this->hasMany(Transferor::class);
		}

		public function legal_transferts(): BelongsToMany
		{
			return $this->belongsToMany(LegalTransfert::class)->withPivot('price');
		}

		public function activity(): HasMany
		{
			return $this->hasMany(ActivityRate::class, 'pays_id');
		}

	}
