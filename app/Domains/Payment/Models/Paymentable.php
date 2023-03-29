<?php

	namespace App\Domains\Payment\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;

	final class Paymentable extends Model
	{
		use HasFactory;

		protected $guarded = [];
	}
