<?php

	namespace App\Http\Controllers\API;

	use App\Domains\Slip\resources\SlipCollection;
	use App\Http\Controllers\Controller;
	use App\Models\Slip;
	use Illuminate\Http\Response;

	class ApiSlipController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 * @return Response
		 */
		public function index()
		{
			return new SlipCollection(Slip::all());
		}
	}
