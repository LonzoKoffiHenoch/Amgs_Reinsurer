<?php

	namespace App\Http\Controllers;

	use App\Models\Transferor;
	use Inertia\Inertia;

	class TransferorController extends Controller
	{
		public function index()
		{
			//recupere toutes les cedentes avec les affires
			$cedente = Transferor::has('businesses', '>', '1')->with('businesses')->get();


			return Inertia::render('Transferor/IndexTransferor', compact('cedente'));
		}

		public function paiement()
		{
			return Inertia::render('Payment/IndexPayment');
		}


	}
