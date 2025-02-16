<?php

namespace App\Http\Controllers\Auth;

use App\Services\Customer\ProfileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProfileFilledController extends Controller
{
    private ProfileService $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            Session::flash('success', 'verified');
        }

        if ($request->user()->isProfilled()) {
            Session::flash('success', 'authenticated');
            return redirect(route('dashboard', absolute: false));
        }

        return Inertia::render('Auth/ProfileFilled');
    }

    public function store(ProfileUpdateRequest $request)
    {

        $isSuccess = $this->service->update($request);

        if (!$isSuccess) {
            return back()->with('error', 'profiled-failed');
        }

        Session::flash('success', 'registered');

        return redirect(route('dashboard', absolute: false));
    }
}
