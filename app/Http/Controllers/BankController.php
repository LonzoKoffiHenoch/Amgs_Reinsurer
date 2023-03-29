<?php

	namespace App\Http\Controllers;

	use App\Models\Bank;
	use App\Models\Company;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;

	class BankController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 * @return Response
		 */
		public function index()
		{
			//
		}

		/**
		 * Store a newly created resource in storage.
		 * @param Request $request
		 * @return Response
		 */
		public function store(Request $request)
		{
			// dd($request);
			$validate = $request->validate([
				"raison_social" => "required",
				"rib" => "required",
				"num_compte" => "required",
				"code_agence" => "required",
				"code_bank" => "required",
				"devise" => "required",
				"swift" => 'required',
				"iban" => 'required',
				"pays_id" => 'required'
			]);
			$validate['pays_id'] = $request['pays_id']['id'];
			$companies = Company::First();
			$validate['user_id'] = auth()->user()->id;
			$companies->banks()->create($validate);
		}

		/**
		 * Show the form for creating a new resource.
		 * @return Response
		 */
		public function create()
		{
			//
		}

		/**
		 * Display the specified resource.
		 * @param Bank
		 * @return Response
		 */
		public function show(Bank $bank)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 * @param Bank
		 * @return Response
		 */
		public function edit(Bank $bank)
		{
			return response()->json([
				'bank' => $bank
			]);
		}


		public function update(Request $request, Bank $bank)
		{
			$request->validate([
				"label" => "required",
			]);
			$bank->update(['label' => $request->label]);
		}

		/**
		 * Remove the specified resource from storage.
		 * @param Bank $id
		 * @return Response
		 */
		public function destroy(Bank $bank)
		{
			// dd($bank);
			$bank->delete();
		}
	}
