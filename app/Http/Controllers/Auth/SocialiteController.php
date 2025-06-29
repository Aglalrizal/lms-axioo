<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
class SocialiteController extends Controller
{
    public function redirectToProvider($provider){
        if(!in_array($provider, ['google'])){
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Throwable $e) {
            return redirect(route('login'))->withErrors(['provider' => 'Something went wrong']);
        }
    }

    public function handleProviderCallback($provider){

        if(!in_array($provider, ['google'])){
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }

        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        // Check if the user already exists in the database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // Log the user in if they already exist
            Auth::login($existingUser);
        } else {
            // Otherwise, create a new user and log them in
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'username' => $user->name,
                'email_verified_at' => now(),
                'provider_id' => $user->id,
                'provider_name' => "google",
                'provider_token' => $user->token,
                'provider_refresh_token' => $user->refreshToken,
            ]);
            Auth::login($newUser);
        }

        // Redirect the user to the dashboard or any other secure page
        return redirect('/dashboard');
    }
}
