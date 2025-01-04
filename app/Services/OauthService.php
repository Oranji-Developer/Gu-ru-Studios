<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\OauthInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class OauthService implements OauthInterface
{
    public function handleProviderCallback(): bool
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('gauth_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                Log::info("User Logged In Successfully");

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => now(),
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'role' => 'customer',
                ]);

                Auth::login($newUser);

                Log::info("User Created and Login Successfully");

            }

            return true;
        } catch (Exception $e) {
            Log::error("Error To Login With Google" . $e->getMessage());
            return false;
        }
    }
}
