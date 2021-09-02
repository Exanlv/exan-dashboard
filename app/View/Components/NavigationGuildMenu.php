<?php

namespace App\View\Components;

use App\Helpers\DiscordHelper;
use Illuminate\View\Component;

class NavigationGuildMenu extends Component
{
    public string $userId;
    public string $username;
    public string $avatarUrl;

    /**
     * @var \App\Entity\DiscordGuild[]
     */
    public array $guilds;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * @var \App\Entity\DiscordUser
         */
        $discordUser = request()->session()->get('discord-user');

        $this->guilds = $discordUser->guilds;
        $this->username = $discordUser->username;
        $this->userId = $discordUser->id;

        $this->avatarUrl = DiscordHelper::getAvatarUrl($this->userId, $discordUser->avatar);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navigation-guild-menu');
    }
}
