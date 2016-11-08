<?php

namespace App\Services;

use GuzzleHttp\Client;

class Nisam
{
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('NISAM_API_URL', 'http://nisam.goxlab.com'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function status()
    {
        $response = $this->client->request('GET', 'api/status');
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}
