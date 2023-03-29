<?php
	declare(strict_types=1);

	namespace App\Domains\Setting\DataObjects;

	use App\Contracts\DataObjectContract;

	final class UploadActivitiesDataObject implements DataObjectContract
	{
		public function __construct(
			public string $type,
			public array  $pays,
			public array  $data,
			public string $activity_ratable_type,
			public int    $activity_ratable_id
		)
		{
		}

		public function toArray(): array
		{
			return [
				'type' => $this->type,
				'data' => $this->data,
				'pays' => $this->pays,
				'activity_ratable_type' => $this->activity_ratable_type,
				'activity_ratable_id' => $this->activity_ratable_id,
			];
		}
	}