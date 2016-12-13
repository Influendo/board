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
        $this->getIp();

        $this->client = new Client;
    }

    /**
     * Get users IP address
     *
     * @return string
     */
    public function getIp()
    {
        // If ip address is on local network
        if ((0 === strpos($this->ip, '192.168.')) or (0 === strpos($this->ip, '172.')) or (0 === strpos($this->ip, '10.'))) {
            $this->ip = file_get_contents('http://ipecho.net/plain');
        } else {
            $this->ip = Request::ip();
        }

        return $this->ip;
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
