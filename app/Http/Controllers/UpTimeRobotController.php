<?php

namespace App\Http\Controllers;

use App\Services\UpTimeRobot;
use Illuminate\Http\Response;

class UpTimeRobotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  UpTimeRobot $robot
     */
    public function __construct(UpTimeRobot $robot)
    {
        $this->robot = $robot;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->robot->monitors(['778340258', '778089655', '778089656']);

        return response()->json(['monitors' => $result->monitors->monitor]);
    }
}
