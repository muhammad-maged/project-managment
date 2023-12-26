<?php

namespace App\Services;

use GuzzleHttp\Client;

class SlackService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://slack.com/api/',
        ]);
    }

    public function integrateWorkspace(array $data)
    {
        $response = $this->client->post('oauth.v2.access', [
            'form_params' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    public function listChannels()
    {
        $response = $this->client->get('conversations.list');

        return json_decode($response->getBody(), true);
    }
}
