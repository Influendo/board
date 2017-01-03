<?php

namespace App\Http\Controllers;

use App\Services\EuroJackpot;
use Illuminate\Http\Response;

class EuroJackpotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  EuroJackpot $eurojackpot
     */
    public function __construct(EuroJackpot $eurojackpot)
    {
        $this->eurojackpot = $eurojackpot;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->eurojackpot->index();

        return response()->json($result);
    }
}
