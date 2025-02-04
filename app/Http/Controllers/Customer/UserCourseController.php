<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UserCourse\StoreUserCourseRequest;
use App\Http\Requests\Customer\UserCourse\UpdateUserCourseRequest;
use App\Models\UserCourse;
use App\Services\Shared\UserCourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $user = Auth::user();
        $data = UserCourse::with('course:id,title,desc,course_type,class,thumbnail')
            ->whereHas('children', function ($query) use ($user) {
                $query->whereIn('children_id', $user->children->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['id', 'course_id', 'children_id', 'status']);

        return Inertia::render('User/UserCourse/Index', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserCourseRequest $request
     * @return RedirectResponse
     * */
    public function store(StoreUserCourseRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('user.course.index')->with('success', 'Data berhasil disimpan!!')
            : redirect()->route('user.course.index')->with('error', 'Data gagal disimpan!!');
    }

    /**
     * Show the specified resource.
     *
     * @param $id
     * @return Response|RedirectResponse
     */
    public function show($id): Response|RedirectResponse
    {
        $data = UserCourse::with(['children:id,name,user_id', 'course:id,title,desc,course_type,class,thumbnail'])
            ->findOrFail($id);

        if (Gate::denies('can-view', $data->children)) {
            return redirect()->route('user.course.index')->with('error', 'Anda tidak memiliki akses!!');
        }

        return Inertia::render('User/UserCourse/Show', [
            'data' => $data
        ]);
    }
}
