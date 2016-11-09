<?php

namespace App\Http\Controllers;

use App\Services\WhatsDone;
use Illuminate\Http\Response;

class WhatsDoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  WhatsDone $whatsDone
     */
    public function __construct(WhatsDone $whatsDone)
    {
        $this->whatsDone = $whatsDone;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->whatsDone->latest();

        return response()->json($result);
    }
}
