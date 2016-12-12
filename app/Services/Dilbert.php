<?php

namespace App\Services;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;

class Dilbert
{
    public $base = 'http://dilbert.com/strip/';

    public function __construct()
    {
        $client = new GuzzleClient([
            'timeout'  => 2.0,
        ]);

        $this->client = new Client();
        $this->client->setClient($client);
    }

    public function byDate(String $date)
    {
        $result = [
            'author' => 'Scott Adams',
            'date' => $date,
            'url' => $this->base . $date,
            'image' => null,
        ];

        $cache = \Cache::remember('dilbert.' . $date, 60*1, function() use($result) {
            $crawler = $this->client->request('GET', $result['url']);
            $select = $crawler->filter('img.img-comic');

            $result['url'] = $select->getUri();
            $result['date'] = explode('/', $result['url']);
            $result['date'] = end($result['date']);

            if ($select->count()) {
                $result['image'] = $select->first()->attr('src');
            }
            else {
                $result = [ 'error' => 'Unable to parse comic img.' ];
            }

            return json_encode($result);
        });

        return json_decode($cache);
    }

    public function latest()
    {
        return $this->byDate(date('Y-m-d'));
    }
}
