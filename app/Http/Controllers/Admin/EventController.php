<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\StoreEventRequest;
use App\Http\Requests\Admin\Event\UpdateEventRequest;
use App\Models\Event;
use App\Services\Admin\EventService;
use Illuminate\Http\RedirectResponse;
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
        $search = request('search', '');
        $status = request('status', '');

        $events = Event::select('id', 'title', 'desc', 'disc', 'status', 'start_date', 'end_date')
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->paginate(5);

        return Inertia('Admin/Event/Index', [
            'events' => $events,
            'status' => StatusEnum::getValues(),
            'activeStatus' => $status,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia('Admin/Event/Create', [
            'status' => StatusEnum::getValues(),
            'course_types' => CourseType::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'arts_class' => ArtsClass::getValues(),
        ]); //menyesuaikan page frontend create mawon
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreEventRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.')
            : redirect()->back()->with('error', 'Event gagal ditambahkan.');
    }


    /**
     * Display the specified resource.
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        $event = Event::findOrFail($id);
        return Inertia('Admin/Event/Show', [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $event = Event::findOrFail($id);

        return Inertia('Admin/Event/Edit', [
            'event' => $event,
            'course_types' => CourseType::getValues(),
            'academic_class' => AcademicClass::getValues(),
            'arts_class' => ArtsClass::getValues(),
            'status' => StatusEnum::getValues(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateEventRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateEventRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.event.index')->with('success', 'Data event berhasil diupdate!!.')
            : redirect()->back()->with('error', 'Data event gagal diupdate!!.');
    }
}
