<?php

namespace App\Entity;

class DiscordGuild
{
    public string $id;
    public string $name;
    public string $permissions;
    public ?string $icon;
}