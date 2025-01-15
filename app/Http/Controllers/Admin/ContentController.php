<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Contents\ContentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreContentRequest;
use App\Http\Requests\Admin\Content\UpdateContentRequest;
use App\Models\Content;
use App\Services\Admin\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContentController extends Controller
{
    public function __construct(private readonly ContentService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Content/Index', [
            'data' => Content::select(['id', 'title', 'desc', 'type', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Content/Create', [
            'types' => ContentType::getValues()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContentRequest $request
     * @return RedirectResponse
     */
    public function store(StoreContentRequest $request): RedirectResponse
    {
        $isSuccess = $this->service->store($request);

        return $isSuccess
            ? redirect()->route('admin.content.index')->with('success', 'Content berhasil dibuat')
            : redirect()->back()->with('error', 'Content gagal dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        return Inertia::render('Admin/Content/Edit', [
            'data' => Content::with('files')->findOrFail($id),
            'types' => ContentType::getValues()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContentRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateContentRequest $request, string $id): RedirectResponse
    {
        $isSuccess = $this->service->update($request, $id);

        return $isSuccess
            ? redirect()->route('admin.content.index')->with('success', 'Content berhasil diupdate')
            : redirect()->back()->with('error', 'Content gagal diupdate');
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
            ? redirect()->route('admin.content.index')->with('success', 'Content berhasil dihapus')
            : redirect()->back()->with('error', 'Content gagal dihapus');
    }
}
