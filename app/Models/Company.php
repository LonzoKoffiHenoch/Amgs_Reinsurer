<?php

	namespace App\Models;

	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\MorphMany;
	use Illuminate\Database\Eloquent\SoftDeletes;

	final class Company extends Model
	{
		use HasFactory;
		use Searchable;
		use SoftDeletes;

		protected $fillable = [];

		protected array $searchableFields = ['*'];

		public function banks(): MorphMany
		{
			return $this->morphMany(Bank::class, 'bankable');
		}
	}
