<?php

namespace App\Services;

use DOMDocument;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class Dilbert
{
    public $base = 'http://dilbert.com/strip/';

    public function __construct()
    {
        $this->client = new GuzzleClient([
            'timeout'  => 60,

        ]);
    }

    public function byDate(String $date)
    {
        $result = [
            'url' => $this->base . $date,
            'date' => $date,
            'author' => null,
            'title' => null,
            'score' => null,
            'image' => null,
        ];

        $cache = \Cache::remember('dilbert.' . $date, 60*1, function() use($result) {
            $html = $this->client->request('GET', $result['url'])->getBody()->getContents();

            $pattern = '/<meta property="og:image" content="(.*?)"/';
            preg_match($pattern, $html, $match);
            if ($match)
                $result['image'] = $match[1];

            $pattern = '/<meta property="og:title" content="(.*?)"/';
            preg_match($pattern, $html, $match);
            if ($match)
                $result['title'] = $match[1];

            return json_encode($result);
        });

        return json_decode($cache);
    }

    public function latest()
    {
        return $this->byDate(date('Y-m-d'));
    }
}
