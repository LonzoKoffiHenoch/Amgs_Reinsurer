<?php

	namespace App\Http\Controllers;

	use App\Models\Pays;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;

	class PaysController extends Controller
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
				"label" => "required|unique:App\\Models\Pays"
			]);
			Pays::create(['label' => $request->label]);
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
		 * @param Pays
		 * @return Response
		 */
		public function show(Pays $pays)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 * @param Pays
		 * @return Response
		 */
		public function edit(Pays $pays)
		{
			// dd($pays);
			return response()->json([
				'countries' => $pays
			]);
		}

		/**
		 * Update the specified resource in storage.
		 * @param Request $request
		 * @param Pays
		 * @return Response
		 */
		public function update(Request $request, Pays $pays)
		{
			$request->validate([
				"label" => "required",
			]);
			$pays->update(['label' => $request->label]);
		}

		/**
		 * Remove the specified resource from storage.
		 * @param int $id
		 * @return Response
		 */
		public function destroy(Pays $pays)
		{

			$pays->delete();
		}
	}
