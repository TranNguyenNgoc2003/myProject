<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginCallback extends Controller
{
    public function handleProviderCallback($provider)
    {
        $socialiteProfile = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialiteProfile->id . '@' . $provider . '.com'],
            [
                'fullname' => $socialiteProfile->name,
                'social_provider' => $provider,
                'social_id' => $socialiteProfile->id,
            ]
        );

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
