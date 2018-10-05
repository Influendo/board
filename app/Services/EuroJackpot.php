<?php

namespace App\Services;

use Cache;

use Carbon\Carbon;
use GuzzleHttp\Client;

class EuroJackpot
{
    public $jackpot = 'https://www.magayo.com/api/jackpot.php?api_key={api_key}&game={game}';
    public $results = 'https://www.magayo.com/api/results.php?api_key={api_key}&game={game}&draw={draw}';

    public function __construct()
    {
        $this->client = new Client;
    }

    public function index($cache = null)
    {

        // since we only have 10 requests per months
        // allowed on api we'll cache result and
        // store it until next week
        $cache = Cache::rememberForever('eurojackpot', function() {
            $url = 'https://www.lutrija.hr/cms/eurojackpot';
            $html = file_get_contents($url);
            $lastRound = '0';
            $lastDate = '00.00.0000';
            $lastDraw = array();
            $nextRound = '0';
            $nextDate = '00.00.0000';
            $nextAmount = "0,00 kn";

            $subject = $html;
            $pattern = '/<p id="date-info">[\s\S]*?<span>([\s\S]*?) odigrano ([\s\S]*?)<\/span>/';
            if (preg_match($pattern, $subject, $matches)) {
                $lastRound = trim($matches[1]);
                $lastDate = trim($matches[2]);
            }

            $subject = $html;
            $pattern = '/<div id="winnings-info">[\s\S]*?<ul.*?>([\s\S]*?)<\/ul>/';
            if (preg_match($pattern, $subject, $matches)) {
                $subject = $matches[1];
                $pattern = '/<li.*?>(.*?)<\/li>/';
                if (preg_match_all($pattern, $subject, $matches)) {
                    $lastDraw = $matches[1];
                }
            }

            $subject = $html;
            $pattern = '/(\d+\. kolo) – izvlačenje brojeva u .*? (\d+\.\d+\.\d+\.)/';
            if (preg_match($pattern, $subject, $matches)) {
                $nextRound = $matches[1];
                $nextDate = $matches[2];
            }

            $subject = $html;
            $pattern = '/<div class="jackpot-info">[\s\S]*?<h4.*?>(.*?)<\/h4>/';
            $pattern = '/<h3 class="countdown-prize".*?>([\s\S]*?)<\/h3>/';
            if (preg_match($pattern, $subject, $matches)) {
                $nextAmount = trim($matches[1]);
                $nextAmount = trim($nextAmount, chr(194) . chr(160));
            }

            return json_encode([
                'nextDraw' => [
                    'id' => $nextRound,
                    'datetime' => $nextDate,
                    'tv' => null,
                    'jackpot' => $nextAmount,
                    'prizes' => null,
                    'paymentLock' => null,
                    'mainTable' => null,
                    'starTable' => null,
                ],
                'lastDraw' => [
                    'id' => $lastRound,
                    'datetime' => $lastDate,
                    'tv' => null,
                    'jackpot' => null,
                    'prizes' => [],
                    'paymentLock' => null,
                    'mainTable' => array_slice($lastDraw, 0, 5),
                    'starTable' => array_slice($lastDraw, -2, 2),
                ],
            ]);
        });

        // recache 2 days after draw (monday
        // is the best day to do that ;-))
        $result = json_decode($cache);
        //\Log::info(print_r($cache, true));
        $now = Carbon::now('Europe/Zagreb')->timestamp;
        $draw = Carbon::parse($result->nextDraw->datetime,'Europe/Helsinki')->timestamp;
        if ($now - $draw > 60*60*24*2) {
            Cache::forget('eurojackpot');
        }

        return $result;
    }

}
