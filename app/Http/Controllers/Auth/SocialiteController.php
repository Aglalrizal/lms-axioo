<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google'])) {
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (Throwable $e) {
            return redirect(route('login'))->withErrors(['provider' => 'Something went wrong']);
        }
    }

    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, ['google'])) {
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Buat user baru kalau belum ada
            $user = User::create([
                'username'             => Str::slug($googleUser->name, '') . now()->timestamp,
                'first_name'           => strstr($googleUser->name, " ", true),
                'surname'              => ltrim(strstr($googleUser->name, " ")),
                'email'                => $googleUser->email,
                'email_verified_at'    => now(),
                'provider_id'          => $googleUser->id,
                'provider_name'        => 'google',
                'provider_token'       => $googleUser->token,
                'provider_refresh_token' => $googleUser->refreshToken ?? null,
            ]);

            // Assign role default (misalnya student)
            $user->assignRole('student');
        }

        Auth::login($user, true);

        // Redirect sesuai role
        if ($user->hasRole(['super-admin','admin'])) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->intended('/instructor/dashboard');
        }

        return redirect()->intended('/student/dashboard');
    }
}
