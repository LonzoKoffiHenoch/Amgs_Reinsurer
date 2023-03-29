<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse as BusinesseAlias;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;

	final class LegalTransfert extends Model
	{
		use HasFactory;

		protected $with = ['reinsurer'];


		public function reinsurer(): BelongsTo
		{
			return $this->belongsTo(Reinsurer::class);
		}

		public function pays(): BelongsToMany
		{
			return $this->belongsToMany(Pays::class)->withPivot('price');
		}
	}
