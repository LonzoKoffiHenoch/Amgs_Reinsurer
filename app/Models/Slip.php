<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\HasMany;


	final class Slip extends Model
	{
		use HasFactory;

		protected $fillable = ['label', 'prime_total'];
		protected array $cast = [
			'prime_total' => 'decimal'
		];

		public function business(): HasMany
		{
			return $this->hasMany(Businesse::class);
		}
	}
