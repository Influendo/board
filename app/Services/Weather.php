<?php

namespace App\Services;

use Request;
use GuzzleHttp\Client;

class Weather
{

    public $api_key = 'd1f602d8be6110ba6fad072f5d299fde';

    public $units = 'metric';

    public $geoIpKey = 'cc9a55dfd12b18d9dc2ffc89347df5c7';

    public $base = 'http://api.openweathermap.org/data/2.5/';

    public $url_current = '{base}weather?appid={api_key}&units={units}&lat={geoip.latitude}&lon={geoip.longitude}';

    public $url_fiveday = '{base}forecast?appid={api_key}&units={units}&lat={geoip.latitude}&lon={geoip.longitude}';

    public function __construct()
    {
        $this->ip = Request::ip();

        // if ip address is on local network
        if ((0 === strpos($this->ip, '192.168.')) or (0 === strpos($this->ip, '172.')) or (0 === strpos($this->ip, '10.'))) {
            $this->ip = file_get_contents('http://ipecho.net/plain');
        }

        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 100,
        ]);
    }

    public function current()
    {
        \Cache::forget('geoip.'. $this->ip);
        $geoip = \Cache::remember('geoip.'. $this->ip, 60*6, function() {
            $response = $this->client->request('GET', 'http://api.ipstack.com/'.$this->ip.'?access_key=' . $this->geoIpKey);
            return @json_decode((string) $response->getBody());
        });

        $latitude = $geoip->latitude;
        $longitude = $geoip->longitude;

        $result = \Cache::remember('weather.current.' . $this->ip, 60*0.5, function() use($latitude, $longitude) {
            $url = $this->url_current;
            $url = str_replace('{base}', $this->base, $url);
            $url = str_replace('{api_key}', $this->api_key, $url);
            $url = str_replace('{units}', $this->units, $url);
            $url = str_replace('{geoip.latitude}', $latitude, $url);
            $url = str_replace('{geoip.longitude}', $longitude, $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $result;
    }

    public function fiveday()
    {
        $geoip = \Cache::remember('geoip.'. $this->ip, 60*6, function() {
            $response = $this->client->request('GET', 'http://freegeoip.net/json/' . $this->ip);
            return @json_decode((string) $response->getBody());
        });

        $latitude = $geoip->latitude;
        $longitude = $geoip->longitude;

        $result = \Cache::remember('weather.fiveday.' . $this->ip, 60*0.5, function() use($latitude, $longitude) {
            $url = $this->url_fiveday;
            $url = str_replace('{base}', $this->base, $url);
            $url = str_replace('{api_key}', $this->api_key, $url);
            $url = str_replace('{units}', $this->units, $url);
            $url = str_replace('{geoip.latitude}', $latitude, $url);
            $url = str_replace('{geoip.longitude}', $longitude, $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $result;
    }
}
