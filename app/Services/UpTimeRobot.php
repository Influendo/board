<?php

namespace App\Services;

use GuzzleHttp\Client;

class UpTimeRobot
{
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('UPTIMEROBOT_API_URL', 'https://api.uptimerobot.com'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    public function monitors($ids = [])
    {
        return @json_decode(''
. '{"monitors":'
. '{"monitor":['
. '{"id":"778089655","friendlyname":"OptimizeLeads DEV","url":"http://opleads.optimizegraphics.com","type":"1","subtype":"","keywordtype":"","keywordvalue":"","httpusername":"","httppassword":"","port":"","interval":"300","status":"2","alltimeuptimeratio":"99.81"}'
. ','
. '{"id":"778089656","friendlyname":"OptimizeLeads","url":"https://www.optimizeleads.com","type":"1","subtype":"","keywordtype":"","keywordvalue":"","httpusername":"","httppassword":"","port":"","interval":"300","status":"2","alltimeuptimeratio":"100"}'
. ','
. '{"id":"778340258","friendlyname":"Nisam","url":"http://nisam.goxlab.com","type":"1","subtype":"","keywordtype":"","keywordvalue":"","httpusername":"","httppassword":"","port":"","interval":"300","status":"2","alltimeuptimeratio":"99.9"}'
. ','
. '{"id":"778349480","friendlyname":"OptimizePress","url":"http://www.optimizepress.com/","type":"1","subtype":"","keywordtype":"","keywordvalue":"","httpusername":"","httppassword":"","port":"","interval":"300","status":"2","alltimeuptimeratio":"100"}'
. ']}'
. '}'
);

        $ids = implode("-", $ids);
        $response = $this->client->request('GET', 'getMonitors', [
            'query' => ['apiKey' => env('UPTIMEROBOT_KEY'), 'format' => 'json', 'nojsoncallback' => 1, 'monitors' => $ids]
        ]);
        $result = @json_decode((string) $response->getBody());

        return $result;
    }
}
