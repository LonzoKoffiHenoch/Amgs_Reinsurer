<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

final class FinanceController extends Controller
{
    public function index():Response
    {
        return Inertia::render('Payment/IndexPayment');
    }
}
