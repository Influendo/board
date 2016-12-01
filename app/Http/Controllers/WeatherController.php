<?php

namespace App\Http\Controllers;

use App\Services\Weather;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Weather $weather
     */
    public function __construct(Weather $weather)
    {
        $this->weather = $weather;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->weather->current();

        return response()->json($result);
    }
}
