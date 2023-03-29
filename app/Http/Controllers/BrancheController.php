<?php

	namespace App\Http\Controllers;

	use App\Models\Branche;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;

	class BrancheController extends Controller
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
			$request->validate([
				"label" => "required|unique:App\\Models\Branche"
			]);
			Branche::create([
				'label' => $request->label,
				'user_id' => auth()->user()->id
			]);
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
		 * @param \App\Models\Branche
		 * @return Response
		 */
		public function show(Branche $branche)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 * @param Branche
		 * @return Response
		 */
		public function edit(Branche $branche)
		{
			return response()->json([
				'branche' => $branche
			]);
		}

		/**
		 * Update the specified resource in storage.
		 * @param Request $request
		 * @param Branche
		 * @return Response
		 */
		public function update(Request $request, Branche $branche)
		{
			$request->validate([
				"label" => "required",
			]);
			// dd($bank);
			$branche->update(['label' => $request->label]);
		}

		/**
		 * Remove the specified resource from storage.
		 * @param int $id
		 * @return Response
		 */
		public function destroy(Branche $branche)
		{
			$branche->delete();
		}
	}
