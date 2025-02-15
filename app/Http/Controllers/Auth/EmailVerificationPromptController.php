<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;


class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        Session::flash('success', 'registered');

        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
