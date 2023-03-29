<?php

	namespace App\Domains\Slip\Http\Controllers;

	use App\Domains\Slip\Actions\TransformDataRequestSlip;
	use App\Domains\Slip\Actions\UploadSlipAction;
	use App\Domains\Slip\Http\Requests\SlipUploadRequest;
	use App\Http\Controllers\Controller;
	use Exception;
	use Illuminate\Http\RedirectResponse;

	class UploadSlipWithErrorController extends Controller
	{
		/**
		 * Handle the incoming request.
		 * @throws Exception
		 */
		public function __invoke(SlipUploadRequest $request): RedirectResponse
		{
			//Transformer la request en array bien formater
			$businesses = (new TransformDataRequestSlip)(request: $request);

			//action uploader le post
			$slip = (new UploadSlipAction)($request, $businesses);


			return redirect(route('slip.showtable', ['borderau' => $slip]));
		}
	}
