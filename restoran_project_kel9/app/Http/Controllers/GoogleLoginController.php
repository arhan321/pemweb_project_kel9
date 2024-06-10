<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        \Log::info('Google user info:', ['googleUser' => $googleUser]);

        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            \Log::info('User not found, creating new user.');
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => \Hash::make(rand(100000, 999999)), // Generate random password
                'google_id' => $googleUser->id, // Save the Google ID
            ]);
        } else {
            \Log::info('User found, updating Google ID if necessary.');
            if (!$user->google_id) {
                $user->google_id = $googleUser->id;
                $user->save();
            }
        }

        Auth::login($user);
        \Log::info('User logged in successfully.', ['user' => $user]);

        return redirect()->intended(RouteServiceProvider::HOME);
    } catch (\Exception $e) {
        \Log::error('Google login error:', ['error' => $e->getMessage()]);
        return redirect('/login')->with('error', 'Failed to login using Google. Please try again.');
    }
}

}
