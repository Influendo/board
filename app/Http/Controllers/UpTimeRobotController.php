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
        $result = $this->robot->monitors([
            '778089655', // OptimizeLeads DEV
            '778089656', // OptimizeLeads
            '778349480', // OptimizePress
            '778340258', // Nisam
        ]);

        return response()->json(['monitors' => $result->monitors->monitor]);
    }
}
