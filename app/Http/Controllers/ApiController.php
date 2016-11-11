<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * Index page
     *
     * @return Response
     */
    public function status()
    {
        $path   = 'update.txt';
        $update = false;
        $exists = Storage::exists($path);

        if ($exists and Storage::delete($path)) {
            $update = true;
        }

        return response()->json(['should_refresh' => $update]);
    }
}
