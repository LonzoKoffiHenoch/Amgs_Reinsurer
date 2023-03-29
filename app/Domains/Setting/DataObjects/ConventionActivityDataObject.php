<?php

	namespace App\Domains\Setting\DataObjects;

	use App\Contracts\DataObjectContract;
	use App\Domains\Setting\Http\Requests\ConventionActivityRequest;
	use App\Models\Pays;

	final class ConventionActivityDataObject implements DataObjectContract
	{
		public function __construct(
			public string    $type,
			public string    $activity,
			public float     $price,
			public Pays|null $pays,
			public array     $transferor
		)
		{
		}

		public static function make(
			ConventionActivityRequest $request
		): self
		{
			return new self(
				type: $request->get('type'),
				activity: $request->get('activity'),
				price: $request->get('price'),
				pays: Pays::find($request->get('pays')['id']),
				transferor: $request->get('transferor')
			);
		}

		public function toArray(): array
		{
			return [
				'type' => $this->type,
				'activity' => $this->activity,
				'price' => $this->price,
				'pays' => $this->pays,
				'transferor' => $this->transferor,
			];
		}
	}