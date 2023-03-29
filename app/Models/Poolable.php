<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Relations\Pivot;

	final class Poolable extends Pivot
	{
		protected $guarded = [];
	}
