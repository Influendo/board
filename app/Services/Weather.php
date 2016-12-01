<?php

namespace App\Services;

use Request;
use GuzzleHttp\Client;

class Weather
{

    public $api_key = 'd1f602d8be6110ba6fad072f5d299fde';

    public $units = 'metric';

    public $base = 'http://api.openweathermap.org/data/2.5/';

    public $url_current = '{base}weather?appid={api_key}&units={units}&lat={geolocation.latitude}&lon={geolocation.longitude}';

    public $url_fiveday = '{base}forecast?appid={api_key}&units={units}&lat={geolocation.latitude}&lon={geolocation.longitude}';

    public function __construct()
    {
        $this->ip = Request::ip();

        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function geolocation()
    {
        $response = $this->client->request('GET', 'http://freegeoip.net/json/' . $this->ip);
        return @json_decode((string) $response->getBody());
    }

    public function current()
    {
        $geolocation = \Cache::remember('geolocation|'. $this->ip, 60*6, function() {
            $response = $this->client->request('GET', 'http://freegeoip.net/json/' . $this->ip);
            return @json_decode((string) $response->getBody());
        });

        $latitude = $geolocation->latitude;
        $longitude = $geolocation->longitude;

        $result = \Cache::remember('weather|current|' . $this->ip, 60*0.5, function() use($latitude, $longitude) {
            $url = $this->url_current;
            $url = str_replace('{base}', $this->base, $url);
            $url = str_replace('{api_key}', $this->api_key, $url);
            $url = str_replace('{units}', $this->units, $url);
            $url = str_replace('{geolocation.latitude}', $latitude, $url);
            $url = str_replace('{geolocation.longitude}', $longitude, $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $result;
    }

    public function fiveday()
    {
        $geolocation = \Cache::remember('geolocation|'. $this->ip, 60*6, function() {
            $response = $this->client->request('GET', 'http://freegeoip.net/json/' . $this->ip);
            return @json_decode((string) $response->getBody());
        });

        $latitude = $geolocation->latitude;
        $longitude = $geolocation->longitude;

        $result = \Cache::remember('weather|current|' . $this->ip, 60*0.5, function() use($latitude, $longitude) {
            $url = $this->url_fiveday;
            $url = str_replace('{base}', $this->base, $url);
            $url = str_replace('{api_key}', $this->api_key, $url);
            $url = str_replace('{units}', $this->units, $url);
            $url = str_replace('{geolocation.latitude}', $latitude, $url);
            $url = str_replace('{geolocation.longitude}', $longitude, $url);

            $response = $this->client->request('GET', $url);

            return @json_decode((string) $response->getBody());
        });

        return $result;
    }
}
