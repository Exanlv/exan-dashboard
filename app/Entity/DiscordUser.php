<?php

namespace App\Entity;

class DiscordUser
{
    public string $id;
    public string $username;
    public string $token;
    public string $avatar;
    public string $discriminator;

    /**
     * @var DiscordGuild[]
     */
    public array $guilds = [];
}