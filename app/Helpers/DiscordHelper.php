<?php

namespace App\Helpers;

use App\Entity\DiscordGuild;
use App\Entity\DiscordUser;
use GuzzleHttp\Client;
use JsonMapper;

class DiscordHelper
{
    private static ?DiscordHelper $instance = null;
    private static string $endpoint = 'https://discord.com/api/v8/';

    private JsonMapper $mapper;
    private Client $httpClient;

    private function __construct()
    {
        $this->httpClient = new Client();
        $this->mapper = new JsonMapper();
    }

    public static function getInstance(): DiscordHelper
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getOAuthUrl(): string
    {
        return 'https://discord.com/oauth2/authorize?client_id='
            . urlencode(config('services.discord.client_id'))
            . '&redirect_uri='
            . urlencode(route('auth.callback'))
            . '&response_type=code&scope=identify%20guilds'
        ;
    }

    public static function getAvatarUrl(string $id, string $avatar, int $size = 128): string
    {
        return "https://cdn.discordapp.com/avatars/$id/$avatar.webp?size=$size";
    }

    /**
     * Get all info for a DiscordUser based on authorization code
     */
    public function getDiscordUser(string $code): DiscordUser
    {
        $response = $this->httpClient->request(
            'POST',
            self::$endpoint . 'oauth2/token',
            [
                'form_params' => [
                    'client_id' => config('services.discord.client_id'),
                    'client_secret' => config('services.discord.client_secret'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => route('auth.callback'),
                ]
            ]
        );

        $data = json_decode((string) $response->getBody());

        $user = $this->getUserData($data->access_token);

        $this->loadGuilds($user);

        return $user;
    }

    /**
     * Retrieve basic data from a discord user
     *  - Name
     *  - ID
     */
    private function getUserData(string $token): DiscordUser
    {
        $response = $this->httpClient->request(
            'GET',
            self::$endpoint . 'users/@me',
            [
                'headers' => [
                    'Authorization' => "Bearer $token",
                ]
            ]
        );

        $user = new DiscordUser();

        $this->mapper->map(
            json_decode((string) $response->getBody()),
            $user
        );

        $user->token = $token;

        return $user;
    }

    /**
     * Populate the guilds of a DiscordUser
     */
    private function loadGuilds(DiscordUser &$user): void
    {
        $response = $this->httpClient->request(
            'GET',
            self::$endpoint . 'users/@me/guilds',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $user->token,
                ]
            ]
        );

        $guilds = json_decode((string) $response->getBody());

        $guildIdsCommon = ExanHelper::getInstance()->getCommonGuilds(
            array_map(function ($guildData) {
                return $guildData->id;
            }, $guilds)
        );

        $guilds = array_filter($guilds, function ($guildData) use ($guildIdsCommon) {
            return in_array($guildData->id, $guildIdsCommon);
        });

        foreach ($guilds as $guildData) {
            $guild = new DiscordGuild();
            $this->mapper->map($guildData, $guild);

            $user->guilds[] = $guild;
        }
    }
}
