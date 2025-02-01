<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\StoreCourseRequest;
use App\Http\Requests\Admin\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\Schedule;
use App\Services\Admin\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{

    public function __construct(private readonly CourseService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $status = request('status', '');
        $filter = request('filter', '');
        $search = request('search', '');

        $statusFields = StatusEnum::getValues();
        $courseType = CourseType::getValues();

        return Inertia::render('Admin/Course/Index', [
            'data' => Course::select(['id', 'thumbnail', 'title', 'status', 'course_type', 'mentor_id'])
                ->withCount([
                    'userCourse' => function ($query) {
                        $query->select('course_id');
                    }
                ])
                ->with([
                    'mentor' => function ($query) {
                        $query->select(['id', 'name'])
                            ->orderBy('name')->take(1);
                    }
                ])
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($filter, function ($query, $filter) {
                    return $query->where('course_type', $filter);
                })
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5),
            'status' => $status,
            'statusFields' => $statusFields,
            'course_type' => $courseType,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Course/Create', [
            'course_type' => CourseType::getValues(),
            'status' => StatusEnum::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'art_class' => ArtsClass::getValues(),
            'mentor' => Mentor::get(['id', 'name', 'field'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCourseRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('admin.course.index')->with('success', 'Berhasil menambahkan data course!!')
            : back()->with('error', 'Gagal menambahkan data course!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        return Inertia::render('Admin/Course/Show', [
            'data' => Course::with([
                'mentor:id,name,field',
                'userCourse' => function ($query) {
                    $query->select(['id', 'course_id', 'children_id'])
                        ->with([
                            'testimonies:id,user_course_id,content',
                            'children.user:id,name'
                        ]);
                }
            ])->findOrFail($id),
            'status' => StatusEnum::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'art_class' => ArtsClass::getValues(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $course = Course::with([
            'mentor:id,name,field',
            'schedule:id,course_id,start_date,end_date,day,start_time,end_time,total_meet',
            'userCourse' => function ($query) {
                return $query->select(['id', 'course_id', 'children_id'])
                    ->with([
                        'testimonies:id,user_course_id,content',
                        'children.user:id,name'
                    ]);
            }
        ])->findOrFail($id);

        return Inertia::render('Admin/Course/Edit', [
            'data' => $course,
            'course_type' => CourseType::getValues(),
            'status' => StatusEnum::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'art_class' => ArtsClass::getValues(),
            'mentor' => Mentor::get(['id', 'name', 'field'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCourseRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateCourseRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.course.index')->with('success', 'Berhasil mengubah data course!!')
            : back()->with('error', 'Gagal mengubah data course!!');
    }
}
