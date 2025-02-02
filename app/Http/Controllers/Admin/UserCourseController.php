<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Users\StatusEnum;
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
        $time = request('time', '');
        $filter = request('filter', '');
        $search = request('search', '');


        $data = UserCourse::with([
            'children' => function ($query) {
                $query->select(['id', 'user_id', 'name'])->with([
                    'user:id,name'
                ]);
            },
            'course' => function ($query) {
                $query->select(['id', 'title', 'thumbnail']);
            },

        ])->when(
                $time,
                function ($query, $status) {
                    return $query->orderBy('created_at', $status === 'Terbaru' ? 'desc' : 'asc');
                }
            )->when(
                $filter,
                function ($query, $filter) {
                    return $query->where('status', $filter);
                }
            )->when(
                $search,
                function ($query, $search) {
                    return $query->whereHas('children', function ($query) use ($search) {
                        $query->whereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                    });
                }
            )->paginate(5);
        return Inertia::render('Admin/UserCourse/Index', [
            'data' => $data,
            'statusFields' => StatusEnum::getValues(),
            'timeFields' => ['Terbaru', 'Terlama']
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
        $userCourseDetail = UserCourse::with([
            'course' => function ($query) {
                $query->with('mentor', 'schedule');
            },
            'children' => function ($query) {
                $query->with('user');
            }
        ])->find($id);

        return Inertia::render('Admin/UserCourse/Edit', [
            'data' => $userCourseDetail,
            'statusFields' => StatusEnum::getValues()
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
