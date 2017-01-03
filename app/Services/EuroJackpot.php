<?php

namespace App\Services;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Collection;

class EuroJackpot
{
    public $base = 'https://www.lutrija.hr/cms/eurojackpot';
    public $timezone = 'Europe/Zagreb';

    public function __construct()
    {
        $client = new GuzzleClient([
            'timeout'  => 10.0,
        ]);

        $this->client = new Client();
        $this->client->setClient($client);
    }

    public function index()
    {
        \Cache::flush();

        $date = date('Y-m-d');
        $result = [
            'nextDraw' => [
                'id' => null,
                'datetime' => null,
                'tv' => null,
                'jackpot' => null,
                'prizes' => null,
                'paymentLock' => null,
                'mainTable' => null,
                'starTable' => null,
            ],
            'lastDraw' => [
                'id' => null,
                'datetime' => null,
                'tv' => null,
                'jackpot' => null,
                'prizes' => null,
                'paymentLock' => null,
                'mainTable' => null,
                'starTable' => null,
            ],
        ];

        // to do: refacture this
        $cache = \Cache::remember('eurojackpot.' . $date, 60*1, function() use($result) {
            $crawler = $this->client->request('GET', $this->base);

            $el = $crawler->filter('.countdown-prize');
            if ($el->count()) {
                $result['nextDraw']['jackpot'] = $el->first()->text();
                $result['nextDraw']['jackpot'] = preg_replace('/\xc2\xa0/', ' ', $result['nextDraw']['jackpot']);
                $result['nextDraw']['jackpot'] = trim($result['nextDraw']['jackpot']);
            }

            $el = $crawler->filter('.countdown-timer');
            if ($el->count()) {
                $result['nextDraw']['paymentLock'] = $el->first()->text();
                $result['nextDraw']['paymentLock'] = preg_replace('/\xc2\xa0/', ' ', $result['nextDraw']['paymentLock']);
                $result['nextDraw']['paymentLock'] = trim($result['nextDraw']['paymentLock']);
                $result['nextDraw']['paymentLock'] = new \DateTime($result['nextDraw']['paymentLock'], new \DateTimeZone($this->timezone));
                $result['nextDraw']['paymentLock'] = $result['nextDraw']['paymentLock']->format('c');
            }

            $el = $crawler->filter('.web-service-text');
            if ($el->count()) {
                $arr = explode(',', $el->first()->text());

                $result['nextDraw']['datetime'] = $arr[0];
                $result['nextDraw']['datetime'] = preg_replace('/\xc2\xa0/', ' ', $result['nextDraw']['datetime']);
                $result['nextDraw']['datetime'] = trim($result['nextDraw']['datetime']);

                if ($result['nextDraw']['paymentLock']) {
                    $val = $result['nextDraw']['datetime'];
                    $result['nextDraw']['datetime'] = new \DateTime($result['nextDraw']['paymentLock'], new \DateTimeZone($this->timezone));
                    $result['nextDraw']['datetime']->modify($val);
                    $result['nextDraw']['datetime'] = $result['nextDraw']['datetime']->format('c');
                }

                $result['nextDraw']['tv'] = $arr[1];
                $result['nextDraw']['tv'] = preg_replace('/\xc2\xa0/', ' ', $result['nextDraw']['tv']);
                $result['nextDraw']['tv'] = trim($result['nextDraw']['tv']);

                $val = $el->parents()->first()->filter('p')->text();
                preg_match('/([0-9]+)\. kolo/', $val, $match);
                if ($match) {
                    $result['nextDraw']['id'] = $match[1];
                }
            }

            $el = $crawler->filter('#date-info span');
            if ($el->count()) {
                $val = $el->first()->text();
                preg_match('/([0-9]+)\. kolo odigrano (.*)/', $val, $match);
                if ($match) {
                    $result['lastDraw']['id'] = $match[1];
                    $result['lastDraw']['datetime'] = new \DateTime(trim($match[2]), new \DateTimeZone($this->timezone));
                    $result['lastDraw']['datetime'] = $result['lastDraw']['datetime']->format('c');
                }
            }

            $el = $crawler->filter('#winnings-info ul li');
            if ($el->count()) {
                $result['lastDraw']['mainTable'] = [];
                $result['lastDraw']['starTable'] = [];

                $el->each(function($node) use(&$result) {
                    $prop = preg_match('/(^|\s)star(\s|$)/', $node->first()->attr('class')) ? 'starTable' : 'mainTable';
                    $result['lastDraw'][$prop][] = $node->first()->text();
                });
            }

            $el = $crawler->filter('#last-round-winnings-content tr');
            if ($el->count()) {
                $result['lastDraw']['prizes'] = [];

                $el->each(function($node, $i) use(&$result) {
                    if (! $i) {
                        return;
                    }

                    $col = $node->filter('th,td');

                    $result['lastDraw']['prizes'][$col->eq(0)->text()] = [
                        'count' => (int) $col->eq(1)->text(),
                        'prize' => $col->eq(3)->text(),
                    ];
                });
            }

            return json_encode($result);
        });

        return json_decode($cache);
    }

}
