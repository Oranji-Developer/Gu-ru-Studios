<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Testimonies\StoreTestimoniesRequest;
use App\Http\Requests\Customer\Testimonies\UpdateTestimoniesRequest;
use App\Models\Testimonies;
use App\Services\Customer\TestimoniesService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TestimoniesController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly TestimoniesService $service)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTestimoniesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTestimoniesRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->back()->with('success', 'Testimony berhasil dibuat!!')
            : redirect()->back()->with('error', 'Testimony gagal dibuat!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTestimoniesRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTestimoniesRequest $request, string $id): RedirectResponse
    {
        $this->authorize('update', Testimonies::find($id));

        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->back()->with('success', 'Testimony berhasil diupdate!!')
            : redirect()->back()->with('error', 'Testimony gagal diupdate!!');
    }
}
