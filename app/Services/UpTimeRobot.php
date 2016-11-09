<?php

namespace App\Services;

use GuzzleHttp\Client;

class UpTimeRobot
{
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('UPTIMEROBOT_API_URL', 'https://api.uptimerobot.com'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function monitors($ids = [])
    {
        $ids = implode("-", $ids);
        $response = $this->client->request('GET', 'getMonitors', [
            'query' => ['apiKey' => env('UPTIMEROBOT_KEY'), 'format' => 'json', 'nojsoncallback' => 1, 'monitors' => $ids]
        ]);
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}