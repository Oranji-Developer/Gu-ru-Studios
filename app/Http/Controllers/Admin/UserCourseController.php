<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCourse\UpdateUserCourseRequest;
use App\Models\UserCourse;
use App\Services\Shared\UserCourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserCourseController extends Controller
{
    public function __construct(private readonly UserCourseService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = UserCourse::paginate(5);
        return Inertia::render('Admin/UserCourse/Index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id): Response
    {
        return Inertia::render('Admin/UserCourse/Edit', [
            'data' => UserCourse::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserCourseRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateUserCourseRequest $request, $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.invoice.index')->with('success', 'Data berhasil diupdate!!')
            : redirect()->route('admin.invoice.index')->with('error', 'Data gagal diupdate!!');
    }
}
