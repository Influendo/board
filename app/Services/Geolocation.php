<?php

namespace App\Services;

use Cache;
use Request;
use GuzzleHttp\Client;

/**
 * User geolocation
 */
class Geolocation
{
    /**
     * @var string
     */
    protected $ip  = null;

    /**
     * @var string
     */
    protected $url = 'http://freegeoip.net/json/';

    /**
     * Init geo service
     */
    public function __construct()
    {
        $this->ip = Request::ip();

        $this->client = new Client;
    }

    /**
     * Get user location by IP address
     *
     * @param  string $ip
     * @return object
     */
    public function getLocationByIp($ip = null)
    {
        $baseUrl = $this->url;

        $geoip = Cache::remember('geoip.'. $this->ip, 60*6, function() use ($baseUrl) {
            $response = $this->client->request('GET', $baseUrl . $this->ip);
            return @json_decode((string) $response->getBody());
        });

        return $geoip;
    }
}
