<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Consume OPL API
 */
class OptimizeLeads
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Init service
     */
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('OPTIMIZELEADS_URL', 'https://my.optimizeleads.com'),
            // You can set any number of default request options.
            'timeout'  => 10.0,
            'headers' => [
                'X-API-Token' => env('OPTIMIZELEADS_API_KEY'),
            ],
        ]);
    }

    /**
     * Return all stats
     *
     * @return array
     */
    public function stats()
    {
        $formatted = [];
        $response = $this->client->request('GET', 'api/stats');
        $result = @json_decode((string) $response->getBody());

        if ($result) {
            foreach ($result as $key => $value) {
                $formatted[$key] = humanize_number($value);
            }
        }

        return $formatted;
    }

}
