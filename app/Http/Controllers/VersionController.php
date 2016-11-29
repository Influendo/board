<?php

namespace App\Http\Controllers;

use App\Services\Version;
use Illuminate\Http\Response;

class VersionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Version $version
     */
    public function __construct(Version $version)
    {
        $this->version = $version;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->version->current();

        return response()->json($result);
    }
}
