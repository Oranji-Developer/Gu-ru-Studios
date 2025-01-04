<?php

namespace App\Http\Controllers\Auth;

use App\Services\Customer\ProfileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
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
        if ($request->user()->isProfilled()) {
            return redirect(route('dashboard', absolute: false));
        }

        return Inertia::render('Auth/ProfileFilled');
    }

    public function store(ProfileUpdateRequest $request)
    {

        $isSuccess = $this->service->update($request);

        if (!$isSuccess) {
            return back()->with('status', 'profiled-failed');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
