<?php

namespace App\Http\Controllers;

use App\Services\Bitbucket;
use Illuminate\Http\Response;

class BitbucketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  Bitbucket $bitbucket
     */
    public function __construct(Bitbucket $bitbucket)
    {
        $this->bitbucket = $bitbucket;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->bitbucket->halloffame();

        return response()->json($result);
    }
}
