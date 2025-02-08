<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Testimonies\StoreTestimoniesRequest;
use App\Http\Requests\Customer\Testimonies\UpdateTestimoniesRequest;
use App\Models\Testimonies;
use App\Services\Customer\TestimoniesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TestimoniesController extends Controller
{
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
     */
    public function update(UpdateTestimoniesRequest $request, string $id): RedirectResponse
    {
        if (Gate::denies('can-update', Testimonies::findOrFail($id)->userCourse->children)) {
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses untuk mengupdate data ini.');
        }

        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->back()->with('success', 'Testimony berhasil diupdate!!')
            : redirect()->back()->with('error', 'Testimony gagal diupdate!!');
    }
}
