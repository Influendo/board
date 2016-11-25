<?php

namespace App\Services;

/*

 Swap library sends api request for each currency, disabling...

*/
/*
use Swap\Builder;

class Currency
{
    public function __construct()
    {
        $this->swap = (new Builder())
            ->add('fixer')
            ->build();
    }

    public function today()
    {
        $results = \Cache::remember('exchange-rate', 5, function() {
            return [
                ['label' => 'GBP/HRK', 'rate' => $this->swap->latest('GBP/HRK')->getValue()],
                ['label' => 'EUR/HRK', 'rate' => $this->swap->latest('EUR/HRK')->getValue()],
                ['label' => 'USD/HRK', 'rate' => $this->swap->latest('USD/HRK')->getValue()],
                ['label' => 'HUF/HRK', 'rate' => $this->swap->latest('HUF/HRK')->getValue()],
            ];
        });

        return $results;
    }
}
*/

use GuzzleHttp\Client;

class Currency
{
    public function __construct()
    {
        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function today()
    {
        $response = $this->client->request('GET', 'http://api.fixer.io/latest?base=HRK&symbols=AUD,CAD,CZK,DKK,HUF,JPY,NOK,SEK,CHF,GBP,USD,EUR,PLN');
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}
