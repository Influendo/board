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
    protected $url = 'http://api.ipstack.com/';

    protected $geoIpKey = 'cc9a55dfd12b18d9dc2ffc89347df5c7';

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
        $requestUrl = $this->url . $this->ip.'?access_key=' . $this->geoIpKey;

        $geoip = Cache::remember('geoip.'. $this->ip, 60*6, function() use ($requestUrl) {
            $response = $this->client->request('GET', $requestUrl);
            return @json_decode((string) $response->getBody());
        });

        return $geoip;
    }
}
