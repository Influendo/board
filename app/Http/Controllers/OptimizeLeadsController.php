<?php

namespace App\Http\Controllers;

use App\Services\OptimizeLeads;
use Illuminate\Http\Response;

class OptimizeLeadsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  OptimizeLeads $optimizeleads
     */
    public function __construct(OptimizeLeads $optimizeleads)
    {
        $this->optimizeleads = $optimizeleads;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->optimizeleads->stats();

        return response()->json(['stats' => $result]);
    }
}
