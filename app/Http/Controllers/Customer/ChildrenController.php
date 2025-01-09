<?php

namespace App\Http\Controllers\Customer;

use App\Enum\Courses\AcademicClass;
use App\Enum\Users\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Children\StoreChildrenRequest;
use App\Http\Requests\Customer\Children\UpdateChildrenRequest;
use App\Models\Children;
use App\Services\Customer\ChildrenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ChildrenController extends Controller
{

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
            'data' => $data
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
            ? redirect()->route('user.children.index')->with('success', 'Berhasil menambahkan data anak!!')
            : back()->with('error', 'Gagal menambahkan data anak!!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return Response|RedirectResponse
     */
    public function show(string $id): Response|RedirectResponse
    {
        $data = Children::findOrFail($id);

        if (Gate::denies('can-view', $data)) {
            return redirect()->route('user.children.index')->with('error', 'Anda tidak memiliki akses untuk melihat data anak ini!!');
        }

        return Inertia::render('Customer/Children/Show', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response|RedirectResponse
     */
    public function edit(string $id)
    {
        $data = Children::findOrFail($id);

        if (Gate::denies('can-view', $data)) {
            return redirect()->route('user.children.index')->with('error', 'Anda tidak memiliki akses untuk melihat data anak ini!!');
        }

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
     */
    public function update(UpdateChildrenRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->childrenService->update($request, $id);

        return $isSuccess
            ? redirect()->route('user.children.index')->with('success', 'Berhasil mengubah data anak!!')
            : back()->with('error', 'Gagal mengubah data anak!!');
    }
}
