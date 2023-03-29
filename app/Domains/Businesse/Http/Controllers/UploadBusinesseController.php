<?php

	namespace App\Domains\Businesse\Http\Controllers;

	use App\Domains\Businesse\Actions\UploadBusinesseAction;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;

	class UploadBusinesseController extends Controller
	{

		public function __invoke(Request $request): RedirectResponse
		{
			(new UploadBusinesseAction)($request);
			return redirect()->route('business.index');
		}
	}
