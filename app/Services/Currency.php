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

    public $url = 'http://api.fixer.io/latest?base={base}&symbols={symbols}';

    public $base = 'HRK';

    public $symbols = [
        "AUD",
        //"BGN",
        //"BRL",
        //"CAD",
        "CHF",
        //"CNY",
        #"CZK",
        #"DKK",
        "EUR",
        "GBP",
        //"HKD",
        //"HRK",
        "HUF",
        //"IDR",
        //"ILS",
        //"INR",
        #"JPY",
        //"KRW",
        //"MXN",
        //"MYR",
        #"NOK",
        //"NZD",
        //"PHP",
        #"PLN",
        //"RON",
        //"RUB",
        #"SEK",
        //"SGD",
        //"THB",
        //"TRY",
        "USD",
        //"ZAR",
    ];

    public function __construct()
    {
        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function today()
    {
        $results = \Cache::remember('currency', 60, function() {
            $url = $this->url;
            $url = str_replace('{base}', $this->base, $url);
            $url = str_replace('{symbols}', implode(',', $this->symbols), $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $results;
    }
}
