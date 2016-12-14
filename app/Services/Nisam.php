<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Handle calls to Nisam API
 */
class Nisam
{
    /**
     * Init service
     */
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('NISAM_API_URL', 'http://nisam.goxlab.com'),
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
    }

    /**
     * Get latest status from API
     *
     * @return array
     */
    public function status()
    {
        $response = $this->client->request('GET', 'api/status');
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}
