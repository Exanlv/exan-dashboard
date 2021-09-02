<?php

namespace App\Helpers;

use App\Entity\DiscordGuild;
use App\Entity\DiscordUser;
use GuzzleHttp\Client;
use JsonMapper;

class ExanHelper
{
    private static ?ExanHelper $instance = null;
    private static string $endpoint;

    private JsonMapper $mapper;
    private Client $httpClient;

    private function __construct()
    {
        self::$endpoint = env('EXAN_URL');

        $this->httpClient = new Client();
        $this->mapper = new JsonMapper();
    }

    public static function getInstance(): ExanHelper
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string[] $guildIds
     * @return string[]
     */
    public function getCommonGuilds(array $guildIds): array
    {
        $response = $this->httpClient->request(
            'POST',
            self::$endpoint . 'exan/guilds/in',
            [
                'json' => $guildIds,
            ]
        );

        /**
         * @var string[]
         */
        $guilds = json_decode((string) $response->getBody());

        return $guilds;
    }
}