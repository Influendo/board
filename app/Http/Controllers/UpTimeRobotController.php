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
        $result = $this->robot->monitors(explode(",", env('UPTIMEROBOT_MONITORS')));

        return response()->json(['monitors' => $result->monitors->monitor]);
    }
}
