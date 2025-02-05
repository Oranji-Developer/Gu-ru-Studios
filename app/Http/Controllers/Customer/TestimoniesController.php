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
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        if (Gate::denies('can-delete', Testimonies::findOrFail($id)->userCourse->children)) {
            return redirect()->route('user.course.index')->with('error', 'Kamu tidak memiliki akses untuk menghapus data ini.');
        }

        $isSuccess = $this->service->destroy($id);

        return $isSuccess
            ? redirect()->back()->with('success', 'Testimony berhasil dihapus!!')
            : redirect()->back()->with('error', 'Testimony gagal dihapus!!');
    }
}
