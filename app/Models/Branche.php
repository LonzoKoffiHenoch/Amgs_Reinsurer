<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse;
	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Branche extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = ['user_id', 'label'];

		protected array $searchableFields = ['*'];

		public function business(): HasOne
		{
			return $this->hasOne(Businesse::class);
		}

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}
	}
