<?php

namespace App\Services;

use Cache;
use Goutte\Client;
use Carbon\Carbon;

class EuroJackpot
{
    public $jackpot = 'https://www.magayo.com/api/jackpot.php?api_key={api_key}&game={game}';
    public $results = 'https://www.magayo.com/api/results.php?api_key={api_key}&game={game}&draw={draw}';

    public function __construct()
    {
        $this->client = new Client;
    }

    public function index()
    {
        // since we only have 10 requests per months
        // allowed on api we'll cache result and
        // store it until next week
        $cache = Cache::rememberForever('eurojackpot', function() {
            // @todo - put this in .env?
            $api_key = 'FAPkC8n32PS9Qz3hPM';
            $game = 'eurojackpot';
            $draw = '';

            // @todo - refactore
            $url = $this->jackpot;
            $url = str_replace('{api_key}', $api_key, $url);
            $url = str_replace('{game}', $game, $url);
            $url = str_replace('{draw}', $draw, $url);
            $response = $this->client->request('GET', $url);
            $jackpot = @json_decode((string) $response->getBody());
            //$jackpot = @json_decode('{"currency":"HRK","error":0,"jackpot":"73000000","next_draw":"2018-07-13"}');
            $draw = date('Y-m-d', strtotime('-7 days', strtotime($jackpot->next_draw)));

            // @todo - refactore
            $url = $this->results;
            $url = str_replace('{api_key}', $api_key, $url);
            $url = str_replace('{game}', $game, $url);
            $url = str_replace('{draw}', $draw, $url);
            $response = $this->client->request('GET', $url);
            $results = @json_decode((string) $response->getBody());
            //$results = @json_decode('{"error":0,"draw":"2018-07-06","results":"02,07,24,38,45,05,08"}');

            return json_encode([
                'nextDraw' => [
                    'id' => date('W', strtotime($jackpot->next_draw)),
                    'datetime' => $jackpot->next_draw . ' 21:00:00',
                    'tv' => null,
                    'jackpot' => number_format($jackpot->jackpot, 0, ',', '.') . ' ' . $jackpot->currency,
                    'prizes' => null,
                    'paymentLock' => null,
                    'mainTable' => null,
                    'starTable' => null,
                ],
                'lastDraw' => [
                    'id' => date('W', strtotime($results->draw)),
                    'datetime' => $results->draw . ' 21:00:00',
                    'tv' => null,
                    'jackpot' => null,
                    'prizes' => [],
                    'paymentLock' => null,
                    'mainTable' => array_slice(explode(',', $results->results), 0, 5),
                    'starTable' => array_slice(explode(',', $results->results), -2, 2),
                ],
            ]);
        });

        // recache 2days after draw (sunday
        // is the best day to do that ;-))
        $result = json_decode($cache);
        $now = Carbon::now('Europe/Zagreb')->timestamp;
        $draw = Carbon::parse($result->nextDraw->datetime,'Europe/Helsinki')->timestamp;
        if ($now - $draw > 60*60*24*2) {
            Cache::forget('eurojackpot');
            return index();
        }

        return $result;
    }

}
