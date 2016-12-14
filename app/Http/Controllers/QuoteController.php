<?php

namespace App\Http\Controllers;

use App\Services\Quote;
use Illuminate\Http\Response;

class QuoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Quote $quote
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->quote->qod();

        return response()->json($result);
    }
}
