<?php

namespace App\Http\Controllers;

use App\Services\Nisam;
use Illuminate\Http\Response;

class NisamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Nisam $nisam
     */
    public function __construct(Nisam $nisam)
    {
        $this->nisam = $nisam;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->nisam->status();

        return response()->json($result);
    }
}
