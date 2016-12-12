<?php

namespace App\Services;

use GuzzleHttp\Client;

class Bitbucket
{

    protected $base = 'https://api.bitbucket.org/2.0';

    public function __construct()
    {
        $this->authentication = env('BITBUCKET_AUTH');

        $this->client = new Client([
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    protected function _url($url, $replace=[])
    {
        $result = $url;
        $result = preg_replace('/{base}/', $this->base, $result);
        foreach($replace as $key => $value) {
            $result = preg_replace("/\{$key\}/", $value, $result);
        }

        return $result;
    }

    protected function _params($params)
    {
        return [
            'query' => $params,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->authentication,
            ],
        ];
    }

    public function teams($username, $params=[])
    {
        $response = $this->client->request('GET',
            $this->_url('{base}/teams/{username}', [ 'username' => $username ]),
            $this->_params($params)
        );

        return @json_decode((string) $response->getBody());
    }

    public function repositories($username, $params=[])
    {
        $response = $this->client->request('GET',
            $this->_url('{base}/repositories/{username}', [ 'username' => $username ]),
            $this->_params($params)
        );

        return @json_decode((string) $response->getBody());
    }

    public function commits($username, $repo_slug, $params=[])
    {
        $response = $this->client->request('GET',
            $this->_url('{base}/repositories/{username}/{repo_slug}/commits', [ 'username' => $username, 'repo_slug' => $repo_slug ]),
            $this->_params($params)
        );

        return @json_decode((string) $response->getBody());
    }

    public function halloffame()
    {
        $result = [
            'interval' => [],
            'team' => [],
            'repositories' => [],
            'users' => [],
            'commits' => [],
        ];

        // interval form monday till today
        $result['interval'] = [
            'from' => date('c', strtotime('monday this week')),
            'to' => date('c'),
        ];

        // get team info
        $response = $this->teams(env('BITBUCKET_TEAM'));
        $result['team'] = [
            'username' => $response->username,
            'website' => $response->website,
            'display_name' => $response->display_name,
            'location' => $response->location,
            'type' => $response->type,
        ];

        // get all repositories of team
        $page = 1;
        $pagelen = 10;
        $next = true;
        while ($next) {
            $response = $this->repositories($result['team']['username'], [ 'page' => $page, 'pagelen' => $pagelen ]);

            foreach($response->values as $repos) {
                $result['repositories'][$repos->slug] = [
                    'scm' => $repos->scm,
                    'name' => $repos->name,
                    'language' => $repos->language,
                    'full_name' => $repos->full_name,
                    'type' => $repos->type,
                    'slug' => $repos->slug,
                    'description' => $repos->description,
                ];
            }

            // has next page?
            $next = property_exists($response, 'next');
            $page++;
        }

        // repositories commits
        foreach($result['repositories'] as $repos) {
            // get last commit -> we need commit hash!!!
            // using hash will prevent calculation offset
            // (user can make commit while this method is
            // already in progress...)
            $response = $this->commits($result['team']['username'], $repos['slug'], [ 'pagelen' => 1, 'page' => 1 ]);
            if (count($response->values) == 0) {
                continue;
            }
            $hash = $response->values[0]->hash;

            // get all commits till hash
            $pagelen = 30;
            $page = 1;
            $next = true;
            while ($next) {
                $response = $this->commits($result['team']['username'], $repos['slug'], [ 'pagelen' => $pagelen, 'page' => $page ]);

                foreach($response->values as $commit) {
                    // out of date
                    if (strtotime($commit->date) < strtotime($result['interval']['from'])) {
                        $next = false;
                        break;
                    }

                    // skip merge
                    if (count($commit->parents) > 1) {
                        continue;
                    }

                    // default (empty) value
                    if (array_key_exists($commit->author->user->username, $result['users']) === false) {
                        $result['users'][$commit->author->user->username] = [
                            'username' => $commit->author->user->username,
                            'display_name' => $commit->author->user->display_name,
                            'type' => $commit->author->user->type,
                            'avatar' => $commit->author->user->links->avatar->href,
                            'commits' => [],
                        ];
                    }

                    // default (empty) commits
                    if (array_key_exists($repos['slug'], $result['users'][$commit->author->user->username]['commits']) === false) {
                        $result['users'][$commit->author->user->username]['commits'][$repos['slug']] = 0;
                    }

                    // increase commits
                    $result['users'][$commit->author->user->username]['commits'][$repos['slug']] += 1;
                }

                // has next page?
                $next = property_exists($response, 'next');
                $page++;
            }
        }

        // commits summary
        $result['commits'] = [
            'repositories' => [],
            'users' => [],
            'max_per_user' => 0,
        ];
        foreach($result['users'] as $user) {
            if (in_array($user['username'], $result['commits']['users']) === false) {
                $result['commits']['users'][] = $user['username'];
            }

            $commits = 0;
            foreach($user['commits'] as $key => $value) {
                if (in_array($key, $result['commits']['repositories']) === false) {
                    $result['commits']['repositories'][] = $key;
                }

                $commits += $value;
            }

            if ($commits > $result['commits']['max_per_user']) {
                $result['commits']['max_per_user'] = $commits;
            }
        }

        return $result;
    }

}
