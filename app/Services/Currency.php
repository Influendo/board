<?php

namespace App\Services;

use Cache;
use GuzzleHttp\Client;

/**
 * All things curency and exchange rates
 */
class Currency
{
    /**
     * @var string
     */
    protected $url = 'https://www.hnb.hr/tecajn/';

    /**
     * @var Geolocation
     */
    protected $geolocation;

    /**
     * @var array
     */
    protected $symbols = [
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

    /**
     * Init the service
     *
     * @param Geolocation $geolocation
     */
    public function __construct(Geolocation $geolocation)
    {
        $this->geolocation = $geolocation;
        $this->client      = new Client;
        $this->ip          = $this->geolocation->getIp();
    }

    /**
     * Exchnage rate for today
     *
     * @return mixed
     */
    public function today()
    {
        // Get user geolocation
        //$geoip = $this->geolocation->getLocationByIp();

        // Fetch currency codes by country
        //$codes = $this->getCodesByCountry();

        // Set base currency code
        //$base = $geoip->country_code ?: 'HR';
        //$base = $codes->$base;
        //$base = $base ?: 'HRK';

        $today = date('dmy');

        // Get exchange rates for today
        $results = \Cache::remember('currency.today.hrk', 60*1, function() use ($today) {
            $url = $this->url . 'f' . $today .'.dat';

            $dataReceived = file_get_contents($url);

            if (!empty($dataReceived)) {
                $dataToBeParsed = explode("\n", $dataReceived);

                // removing header
                array_shift($dataToBeParsed);

                $dataTemp = array();

                foreach ($dataToBeParsed as $data) {
                    $data = explode("      ", $data);
                    $currency = substr($data[0], 3, 3);
                    $value = $data[2];
                    if (in_array($currency, $this->symbols)) {
                        $dataTemp[$currency] = $value;
                    }
                }

                $dataReturned = array(
                    'success' => true,
                    'timestamp' => time(),
                    'base'  => 'HRK',
                    'date'  => date("Y-m-d"),
                    'rates' => $dataTemp
                );

                return $dataReturned;
            }

            //$response = $this->client->request('GET', $url);
            //return @json_decode((string) $response->getBody());
        });

        return $results;
    }

    /**
     * Fetch list of currency codes by country
     *
     * @return object
     */
    public function getCodesByCountry()
    {
        return Cache::remember('currency.codes', 60*24, function() {
            $response = $this->client->request('GET', 'http://country.io/currency.json');
            return @json_decode((string) $response->getBody());
        });
    }
}
