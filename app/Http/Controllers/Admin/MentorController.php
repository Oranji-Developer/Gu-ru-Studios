<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mentor\StoreMentorRequest;
use App\Http\Requests\Admin\Mentor\UpdateMentorRequest;
use App\Models\Mentor;
use App\Services\Admin\MentorService;
use Illuminate\Http\RedirectResponse;
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
        $filter = request('filter', '');

        $mentors = Mentor::select('id', 'name', 'field')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($filter, function ($query, $filter) {
                return $query->where('field', $filter);
            })
            ->paginate(5);

        return Inertia::render('Admin/Mentor/Index', [
            'mentors' => $mentors,
            'search' => $search,
            'filter' => $filter,
            'fields' => CourseType::getValues(),
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
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $mentor = Mentor::findOrFail($id);

        return Inertia::render('Admin/Mentor/Edit', [
            'mentor' => $mentor,
            'fields' => CourseType::getValues(),
            'gender' => GenderEnum::getValues(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMentorRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateMentorRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.mentor.index')->with('success', 'Data Mentor berhasil diupdate!!')
            : redirect()->back()->with('error', 'Data Mentor gagal diupdate!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $isSuccess = $this->service->destroy($id);

        return $isSuccess
            ? redirect()->route('admin.mentor.index')->with('success', 'Data Mentor berhasil dihapus!!')
            : redirect()->back()->with('error', 'Data Mentor gagal dihapus!!');
    }
}
