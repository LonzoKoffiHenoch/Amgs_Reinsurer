<?php

	namespace App\Domains\Slip\Http\Controllers;

	use App\Http\Controllers\Controller;
	use App\Models\Slip;
	use App\Models\Transferor;
	use Illuminate\Http\Request;
	use Inertia\Inertia;
	use Inertia\Response;

	final class SlipController extends Controller
	{

		public function index(): Response
		{
			return Inertia::render('Slip/IndexSlip', [
				'slips' => Slip::all()
			]);
		}

		public function create(): Response
		{
			$transferors = Transferor::all();
			return Inertia::render('Slip/CreateSlip', compact('transferors'));
		}


		public function store(Request $request)
		{
			//
		}

		public function show(Slip $slip)
		{
			//
		}


		public function edit(Slip $slip)
		{
			//
		}


		public function update(Request $request, Slip $slip)
		{
			//
		}


		public function destroy(Slip $slip)
		{
			//
		}
	}
