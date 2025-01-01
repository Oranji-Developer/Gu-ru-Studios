<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OauthService;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OauthController extends Controller
{
    private OauthService $service;

    public function __construct(OauthService $service)
    {
        $this->service = $service;
    }

    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $isSuccess = $this->service->handleProviderCallback();

        return $isSuccess
            ? redirect()->route('dashboard')->with("success", "Login Successfully")
            : redirect()->route('login')->with("error", "Error To Login With Google");
    }
}
