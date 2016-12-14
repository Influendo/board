<?php

namespace App\Services;

use GuzzleHttp\Client;

class Quote
{
    public function __construct()
    {
        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
    }

    public function qod()
    {
        $result = \Cache::remember('quote.qod.', 60*1, function() {
            try {
                $response = $this->client->request('GET', 'http://quotes.rest/qod.json');
            } catch(\Exception $e) {
                $response = $e->getResponse();
            }

            return @json_decode((string) $response->getBody());
        });

        return $result;
    }
}
