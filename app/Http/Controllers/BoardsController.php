<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Controller for board routes
 */
class BoardsController extends Controller
{
    /**
     * Show the board view
     *
     * @return Response
     */
    public function show()
    {
        return view('public.board');
    }

    public function clearCache($key)
    {
        if (Cache::forget($key)) {
            echo 'Cache cleared for key ' . $key;
        } else {
            echo 'Can not clear ' . $key;
        }
    }
}
