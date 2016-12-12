<?php

namespace App\Http\Controllers;

use App\Services\Dilbert;
use Illuminate\Http\Response;

class DilbertController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Dilbert $dilbert
     */
    public function __construct(Dilbert $dilbert)
    {
        $this->dilbert = $dilbert;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->dilbert->latest();

        return response()->json($result);
    }
}
