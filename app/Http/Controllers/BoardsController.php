<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

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
}
