<?php

namespace App\Http\Controllers;

use App\Helpers\DiscordHelper;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        /**
         * The Discord socialite driver requires the email scope, this application does not
         * 
         * Manual oauth time woo
         */
        return redirect()
            ->away(DiscordHelper::getOAuthUrl())
        ;
    }

    public function callback(Request $request)
    {
        $discordHelper = DiscordHelper::getInstance();

        $discordUser = $discordHelper->getDiscordUser($request->input('code'));

        $request->session()->put('discord-user', $discordUser);

        return redirect()->route('home');
    }
}
