<?php

namespace App\Http\Controllers;

use App\Services\Currency;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->currency->today();

        return response()->json($result);
    }
}
