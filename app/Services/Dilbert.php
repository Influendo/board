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
            'url' => $this->base . $date,
            'date' => $date,
            'author' => null,
            'title' => null,
            'image' => null,
        ];

        $cache = \Cache::remember('dilbert.' . $date, 60*1, function() use($result) {
            $crawler = $this->client->request('GET', $result['url']);
            $author = $crawler->filter('meta[property="article:author"]');
            $title = $crawler->filter('.comic-title-name');
            $image = $crawler->filter('img.img-comic');

            $result['url'] = $crawler->getUri();
            $result['date'] = explode('/', $result['url']);
            $result['date'] = end($result['date']);

            if ($author->count()) {
                $result['author'] = $author->first()->attr('content');
            }

            if ($title->count()) {
                $result['title'] = $title->first()->text();
            }

            if ($image->count()) {
                $result['image'] = $image->first()->attr('src');
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
