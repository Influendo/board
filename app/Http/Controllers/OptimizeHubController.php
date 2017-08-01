<?php

namespace App\Http\Controllers;

use App\Services\OptimizeHub;
use Illuminate\Http\Response;

class OptimizeHubController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  OptimizeHub $optimizehub
     */
    public function __construct(OptimizeHub $optimizehub)
    {
        $this->optimizehub = $optimizehub;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->optimizehub->stats();

        return response()->json(['stats' => $result]);
    }
}
