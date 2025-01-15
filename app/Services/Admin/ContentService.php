<?php

namespace App\Services\Admin;

use App\Models\Content;
use App\Services\Abstracts\CrudAbstract;
use App\Trait\FileHandleTrait;
use App\Trait\UpdateHandleTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentService extends CrudAbstract
{
    use UpdateHandleTrait, FileHandleTrait;

    public function store($request): bool
    {
        try {
            DB::beginTransaction();
            $content = Content::create($request->getData());

            foreach ($request->getFiles() as $file) {
                $content->files()->create([
                    'name' => $file['name'],
                    'path' => $file['path']
                ]);
            }

            DB::commit();
            Log::info('success store content');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('error store content: ' . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            DB::beginTransaction();
            $content = Content::with('files')->findOrFail($id);

            $this->handleUpdate($content, $request->getData());

            foreach ($request->getFiles() as $index => $file) {
                $newFile = array_diff_assoc($file, $content->files[$index]->toArray());

                if ($newFile) {
                    $this->deleteFile($content->files[$index]->path);
                    $content->files[$index]->update($newFile);
                }
            }

            DB::commit();
            Log::info('success update content');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('error update content: ' . $e->getMessage());
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            $content = Content::with('files')->findOrFail($id);

            foreach ($content->files as $file) {
                $this->deleteFile($file->path);
            }

            $content->delete();
            Log::info('success delete content');
            return true;
        } catch (\Exception $e) {
            Log::error('error delete content: ' . $e->getMessage());
            return false;
        }
    }
}
