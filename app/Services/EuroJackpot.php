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
        $this->crawler = null;
    }

    private function _parse_nextdraw_id()
    {
        $el = $this->crawler->filter('.countdown-container p');
        if ($el->count()) {
            preg_match('/([0-9]+)\. kolo/', $el->first()->text(), $match);

            if ($match) {
                return $match[1];
            }
        }
    }

    private function _parse_nextdraw_datetime()
    {
        $el = $this->crawler->filter('.web-service-text');
        if ($el->count()) {
            $arr = explode(',', $el->first()->text());

            if (count($arr) >= 1) {
                $result = $arr[0];
                $result = preg_replace('/\xc2\xa0/', ' ', $result);
                $result = trim($result);

                $plock = $this->_parse_nextdraw_paymentlock();
                if ($plock) {
                    $time = $result;

                    $result = new \DateTime($plock, new \DateTimeZone($this->timezone));
                    $result->modify($time);
                    $result = $result->format('c');
                }

               return $result;
            }
        }
    }

    private function _parse_nextdraw_tv()
    {
        $el = $this->crawler->filter('.web-service-text');
        if ($el->count()) {
            $arr = explode(',', $el->first()->text());

            if (count($arr) >= 2) {
                $result = $arr[1];
                $result = preg_replace('/\xc2\xa0/', ' ', $result);
                $result = trim($result);

                return $result;
            }
        }
    }

    private function _parse_nextdraw_jackpot()
    {
        $el = $this->crawler->filter('.countdown-prize');
        if ($el->count()) {
            $result = $el->first()->text();
            $result = preg_replace('/\xc2\xa0/', ' ', $result);
            $result = preg_replace('/\s+/', '', $result);
            $result = trim($result);

            return $result;
        }
    }

    private function _parse_nextdraw_paymentlock()
    {
        $el = $this->crawler->filter('.countdown-timer');
        if ($el->count()) {
            $result = $el->first()->text();
            $result = preg_replace('/\xc2\xa0/', ' ', $result);
            $result = trim($result);
            $result = new \DateTime($result, new \DateTimeZone($this->timezone));
            $result = $result->format('c');

            return $result;
        }
    }

    private function _parse_lastdraw_id()
    {
        $el = $this->crawler->filter('#date-info span');
        if ($el->count()) {
            preg_match('/([0-9]+)\. kolo odigrano (.*)/', $el->first()->text(), $match);

            if ($match) {
                return $match[1];
            }
        }
    }

    private function _parse_lastdraw_datetime()
    {
        $el = $this->crawler->filter('#date-info span');
        if ($el->count()) {
            preg_match('/([0-9]+)\. kolo odigrano (.*)/', $el->first()->text(), $match);

            if ($match) {
                $result = new \DateTime(trim($match[2]), new \DateTimeZone($this->timezone));
                $result = $result->format('c');

                return $result;
            }
        }
    }

    private function _parse_lastdraw_maintable()
    {
        $el = $this->crawler->filter('#winnings-info ul li:not(.star)');
        if ($el->count()) {
            $result = [];

            $el->each(function($node) use(&$result) {
                $result[] = $node->first()->text();
            });

            return $result;
        }
    }

    private function _parse_lastdraw_startable()
    {
        $el = $this->crawler->filter('#winnings-info ul li.star');
        if ($el->count()) {
            $result = [];

            $el->each(function($node) use(&$result) {
                $result[] = $node->first()->text();
            });

            return $result;
        }
    }

    private function _parse_lastdraw_prizes()
    {
        $el = $this->crawler->filter('#last-round-winnings-content tr');
        if ($el->count()) {
            $result = [];

            $el->each(function($node, $i) use(&$result) {
                if (! $i) {
                    return;
                }

                $col = $node->filter('th,td');

                $result[$col->eq(0)->text()] = [
                    'count' => (int) $col->eq(1)->text(),
                    'prize' => preg_replace('/\s+/', '', $col->eq(3)->text()),
                ];
            });

            return $result;
        }
    }

    public function index()
    {
        $date = date('Y-m-d');
        $cache = \Cache::remember('eurojackpot.' . $date, 60*1, function() {
            $this->crawler = $this->client->request('GET', $this->base);

            return json_encode([
                'nextDraw' => [
                    'id' => $this->_parse_nextdraw_id(),
                    'datetime' => $this->_parse_nextdraw_datetime(),
                    'tv' => $this->_parse_nextdraw_tv(),
                    'jackpot' => $this->_parse_nextdraw_jackpot(),
                    'prizes' => null,
                    'paymentLock' => $this->_parse_nextdraw_paymentlock(),
                    'mainTable' => null,
                    'starTable' => null,
                ],
                'lastDraw' => [
                    'id' => $this->_parse_lastdraw_id(),
                    'datetime' => $this->_parse_lastdraw_datetime(),
                    'tv' => null,
                    'jackpot' => null,
                    'prizes' => $this->_parse_lastdraw_prizes(),
                    'paymentLock' => null,
                    'mainTable' => $this->_parse_lastdraw_maintable(),
                    'starTable' => $this->_parse_lastdraw_startable(),
                ],
            ]);
        });

        return json_decode($cache);
    }

}
