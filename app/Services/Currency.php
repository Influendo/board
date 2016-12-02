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

use Request;
use GuzzleHttp\Client;

class Currency
{

    public $url = 'http://api.fixer.io/latest?base={base}&symbols={symbols}';

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
        $this->ip = Request::ip();

        // if ip address is on local network
        if ((0 === strpos($this->ip, '192.168.')) or (0 === strpos($this->ip, '172.')) or (0 === strpos($this->ip, '10.'))) {
            $this->ip = file_get_contents('http://ipecho.net/plain');
        }

        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function today()
    {
        $geoip = \Cache::remember('geoip.'. $this->ip, 60*6, function() {
            $response = $this->client->request('GET', 'http://freegeoip.net/json/' . $this->ip);
            return @json_decode((string) $response->getBody());
        });

        $codes = \Cache::remember('currency.codes', 60*24, function() {
            $response = $this->client->request('GET', 'http://country.io/currency.json');
            return @json_decode((string) $response->getBody());
        });

        $base = $geoip->country_code ?: 'HR';
        $base = $codes->$base;
        $base = $base ?: 'HRK';

        $results = \Cache::remember('currency.today.' . $base, 60*1, function() use($base) {
            $url = $this->url;
            $url = str_replace('{base}', $base, $url);
            $url = str_replace('{symbols}', implode(',', $this->symbols), $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $results;
    }
}
