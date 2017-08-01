<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Consume OPL API
 */
class OptimizeHub
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
        $this->client = new Client;
    }

    /**
     * Return all stats
     *
     * @return array
     */
    public function stats()
    {
        $formatted = [];
        $response = $this->client->request('GET', env('OPTIMIZEHUB_URL'), ['query' => ['secret' => env('OPTIMIZEHUB_API_KEY')]]);
        $result = @json_decode((string) $response->getBody());

        if ($result) {
            foreach ($result as $section => $data) {
                foreach ($data as $key => $value) {
                    $formatted[$section.'_'.$key] = humanize_number($value);
                }
            }
        }

        return $formatted;
    }

}
