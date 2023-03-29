<?php

	declare(strict_types=1);

	namespace App\Domains\Slip\Actions;

	use Illuminate\Http\Request;

	class CheckPriceLegalTransfert
	{
		final public function test(Request $request): Request
		{
			if ($request['prime'] / $request['capital'] >= integerValue()) {
				return $request;
			}

		}
	}
