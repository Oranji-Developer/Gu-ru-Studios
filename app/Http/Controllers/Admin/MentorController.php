<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMentorRequest;
use App\Models\Mentor;
use App\Services\Admin\MentorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MentorController extends Controller
{
    public function __construct(private readonly MentorService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $search = request('search', '');

        $mentors = Mentor::select('id', 'name', 'field')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(5);

        return Inertia::render('Admin/Mentor/Index', [
            'mentors' => $mentors,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Mentor/Create', [
            'fields' => CourseType::getValues(),
            'gender' => GenderEnum::getValues(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMentorRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMentorRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('admin.mentor.index')->with('success', 'Mentor berhasil ditambahkan!!')
            : redirect()->back()->with('error', 'Mentor gagal ditambahkan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        $mentor = Mentor::findOrFail($id);

        return Inertia::render('Admin/Mentor/Show', [
            'mentor' => $mentor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
