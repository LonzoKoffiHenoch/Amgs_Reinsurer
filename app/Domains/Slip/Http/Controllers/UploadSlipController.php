<?php

	namespace App\Domains\Slip\Http\Controllers;

	use App\Domains\Slip\Actions\CheckDataInFileUploadAction;
	use App\Domains\Slip\Actions\TransformDataRequestSlip;
	use App\Domains\Slip\Actions\UploadSlipAction;
	use App\Domains\Slip\Http\Requests\SlipUploadRequest;
	use App\Http\Controllers\Controller;
	use Exception;
	use Illuminate\Http\RedirectResponse;

	class UploadSlipController extends Controller
	{


		/**
		 * @throws Exception
		 */
		public function __invoke(SlipUploadRequest $request): RedirectResponse
		{

			//Verification de calcul
			try {
				app(CheckDataInFileUploadAction::class)->handle($request);
			} catch (Exception $exception) {
				return redirect()->back()->withErrors($exception->getMessage());
			}

			//Transformer la request en array bien formater
			$businesses = (new TransformDataRequestSlip)(request: $request);

			//action uploader le post
			$slip = (new UploadSlipAction)($request, $businesses);


			//event =>envoyer un mail à la comptabilité

			//return redirect
			return redirect(route('slip.showtable', ['borderau' => $slip]));
		}
	}
