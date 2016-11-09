<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhatsDone
{
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('WHATSDONE_API_URL', 'https://whatsdone.today'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function latest()
    {
        $response = $this->client->request('GET', 'indexApiSecretRoute');
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}
