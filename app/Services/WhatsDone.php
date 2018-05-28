<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class WhatsDone
{
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('WHATSDONE_API_URL', 'https://api.whatsdone.today'),
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
    }

    public function latest()
    {
        $results = \Cache::remember('whatsdone', 5, function() {
            $response = $this->client->request('GET', 'indexApiSecretRoute');


            return @json_decode((string) $response->getBody());
        });

        // Format
        $results = $this->formatResults($results);

        return $results;
    }

    public function formatResults($results)
    {
        $parsed = new Collection;

        foreach ($results as $user) {
            if (count($user->tasks)) {
                $taskText = [];

                foreach ($user->tasks as $task) {
                    $taskText[] = $task->body;
                }

                $user->taskBody = implode(", ", $taskText);

                $parsed->push($user);
            }
        }

        return $parsed;
    }
}
