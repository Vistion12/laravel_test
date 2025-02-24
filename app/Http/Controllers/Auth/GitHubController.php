<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        $socialUser = Socialite::driver('github')->user();


        $user = User::query()->where('email', $socialUser->getEmail())->first();


        if (!$user) {
            $user = User::query()->create([
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
                'password' => bcrypt('password'),  // Здесь можно генерировать случайный пароль
            ]);
        }


        Auth::login($user);


        return redirect()->route('home');
    }
}
