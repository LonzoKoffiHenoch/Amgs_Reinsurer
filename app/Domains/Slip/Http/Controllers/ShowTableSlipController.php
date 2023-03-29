<?php

	namespace App\Domains\Slip\Http\Controllers;

	use App\Domains\Slip\Actions\CalculationTableUploadAction;
	use App\Http\Controllers\Controller;
	use App\Models\Slip;
	use Illuminate\Http\Request;
	use Inertia\Inertia;
	use Inertia\Response;

	class ShowTableSlipController extends Controller
	{

		public function __invoke(Request $request, Slip $borderau): Response
		{
			$datas =(new CalculationTableUploadAction())($borderau);

			return Inertia::render('Slip/ShowTableData', [
				'borderau' => $borderau->load( 'business.activity_rate'),
				'datas'=>$datas,
			]);
		}
	}
