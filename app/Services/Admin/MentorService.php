<?php

namespace App\Services\Admin;

use App\Models\Mentor;
use App\Services\Abstracts\CrudAbstract;
use App\Trait\FileHandleTrait;
use App\Trait\UpdateHandleTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class MentorService extends CrudAbstract
{
    use FileHandleTrait, UpdateHandleTrait;

    public function store($request): bool
    {
        try {
            $data = $request->getData();

            Mentor::create($data);

            Log::info("Mentor Created");
            return true;
        } catch (Exception $e) {
            Log::error("Error at Store Mentor " . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            $mentor = Mentor::findOrFail($id);

            $this->handleUpdate(
                $mentor,
                $request->getData(),
                ['profile_picture', 'cv']
            );

            Log::info("Mentor Updated");
            return true;
        } catch (Exception $e) {
            Log::error("Error at Update Mentor " . $e->getMessage());
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            $mentor = Mentor::findOrFail($id);

            $this->deleteFiles([
                $mentor->profile_picture,
                $mentor->cv
            ]);

            $mentor->delete();

            Log::info("Mentor Deleted");
            return true;
        } catch (Exception $e) {
            Log::error("Error at Destroy Mentor " . $e->getMessage());
            return false;
        }
    }
}
