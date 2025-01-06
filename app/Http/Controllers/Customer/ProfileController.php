<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Customer\ProfileService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    private ProfileService $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Settings/Profile', [
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->update($request);

        return $isSuccess
            ? Redirect::route('profile.edit')->with('status', 'Profile berhasil diperbarui!')
            : Redirect::back()->with('error', 'Profile gagal diperbarui!');
    }

    /**
     * Control the user's account form.
     */

    public function editAccount(Request $request): Response
    {
        return Inertia::render('Settings/Account', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function updateAccount(ProfileUpdateRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->update($request);

        return $isSuccess
            ? Redirect::route('account.edit')->with('status', 'Account berhasil diperbarui!')
            : Redirect::back()->with('error', 'Account gagal diperbarui!');
    }


}
