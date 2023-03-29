<?php

	namespace App\Http\Controllers;

	use App\Models\Currency;
	use Illuminate\Http\Request;
	use Inertia\Inertia;
	use Inertia\Response;

	class CurrencyController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 * @return Response
		 */
		public function index()
		{
			return Inertia::render('Setting/Currency/IndexCurrency', ['Currencies' => Currency::query()]);
		}

		/**
		 * Show the form for creating a new resource.
		 * @return void
		 */
		public function create()
		{
			//
		}

		/**
		 * Store a newly created resource in storage.
		 * @param Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
		}

		/**
		 * Display the specified resource.
		 * @param \App\Models\Currency $currency
		 * @return \Illuminate\Http\Response
		 */
		public function show(Currency $currency)
		{
			//
		}

		/**
		 * Show the form for editing the specified resource.
		 * @param \App\Models\Currency $currency
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Currency $currency)
		{
			//
		}

		/**
		 * Update the specified resource in storage.
		 * @param Request $request
		 * @param \App\Models\Currency $currency
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Currency $currency)
		{
			//
		}

		/**
		 * Remove the specified resource from storage.
		 * @param \App\Models\Currency $currency
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Currency $currency)
		{
			//
		}
	}
