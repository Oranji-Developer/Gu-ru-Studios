<?php

namespace App\Http\Controllers\Customer;

use App\Enum\Courses\AcademicClass;
use App\Enum\Users\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Children\StoreChildrenRequest;
use App\Http\Requests\Customer\Children\UpdateChildrenRequest;
use App\Models\Children;
use App\Services\Customer\ChildrenService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ChildrenController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly ChildrenService $childrenService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = Children::where('user_id', auth()->id())->get();

        return Inertia::render('Customer/Children/Index', [
            'data' => $data,
            'gender' => GenderEnum::getValues(),
            'classes' => AcademicClass::getValues()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Customer/Children/Create', [
            'gender' => GenderEnum::getValues(),
            'class' => AcademicClass::getValues()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChildrenRequest $request
     * @return RedirectResponse
     */
    public function store(StoreChildrenRequest $request): RedirectResponse
    {
        $isSuccess = $this->childrenService->store($request);

        return $isSuccess
            ? redirect()->back()->with('success', 'Berhasil menambahkan data anak!!')
            : back()->with('error', 'Gagal menambahkan data anak!!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function show(string $id): Response|RedirectResponse
    {
        $data = Children::findOrFail($id);

        $this->authorize('view', $data);

        return Inertia::render('Customer/Children/Show', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(string $id): Response
    {
        $data = Children::findOrFail($id);

        $this->authorize('view', $data);

        return Inertia::render('Customer/Children/Show', [
            'data' => $data,
            'gender' => GenderEnum::getValues(),
            'class' => AcademicClass::getValues()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChildrenRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateChildrenRequest $request, string $id): RedirectResponse
    {
        $this->authorize('update', Children::findOrFail($id));

        $isSuccess = $this->childrenService->update($request, $id);

        return $isSuccess
            ? redirect()->route('user.children.index')->with('success', 'Berhasil mengubah data anak!!')
            : back()->with('error', 'Gagal mengubah data anak!!');
    }
}
