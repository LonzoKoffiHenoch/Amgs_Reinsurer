<?php

	namespace App\Domains\Setting\Repositories;

	use App\Models\Pays;
	use Illuminate\Support\Collection;


	class CountryRepository
	{
		final public function getAll(): Collection
		{
			return Pays::all()->map(function ($pays) {
				return [
					'id' => $pays->id,
					'label' => ucfirst(mb_strtolower($pays->label))
				];
			});
		}

		public function getById(Pays $id)
		{
			return Pays::findOrFail($id);
		}

		public function delete($id): int
		{
			return Pays::destroy($id);
		}

		public function create(array $attributes): Pays
		{
			return Pays::create($attributes);
		}

		public function update($id, array $attributes): bool
		{
			return Pays::whereId($id)->update($attributes);
		}
	}
