<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Services\Admin\EventService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;


class EventController extends Controller
{

    public function __construct(private readonly EventService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): Response
    {
        $search = request('search');
        $events = Event::select('id', 'title', 'thumbnail', 'desc', 'disc', 'course_type', 'class', 'start_date', 'end_date')
            ->when($search, fn($query, $search) => $query->where('title', 'like', '%'.$search.'%'))
            ->paginate(5);

        return Inertia('Admin/Events/Index',[
            'events' => $events,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Admin/Events/Create',[
            'course_types' => CourseType::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'arts_class' => ArtsClass::getValues(),
        ]); //menyesuaikan page frontend create mawon
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.')
            : redirect()->back()->with('error', 'Event gagal ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return Inertia('Admin/Events/Show', [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        return Inertia('Admin/Events/Edit', [
            'event' => Event::findOrFail($id),
            'course_types' => CourseType::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'arts_class' => ArtsClass::getValues(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.events.index')->with('success', 'Data event berhasil diupdate!!.')
            : redirect()->back()->with('error', 'Data event gagal diupdate!!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $isSuccess = $this->service->destroy($id);

        return $isSuccess
            ? redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus!!.')
            : redirect()->back()->with('error', 'Data event gagal dihapus!!.');
    }
}
