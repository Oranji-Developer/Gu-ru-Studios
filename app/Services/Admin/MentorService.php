<?php

namespace App\Services\Admin;

use App\Models\Mentor;
use App\Services\Abstracts\CrudAbstract;
use Exception;
use Illuminate\Support\Facades\Log;

class MentorService extends CrudAbstract
{
    public function store($request): bool
    {
        try {
            $data = $request->getData();

            Mentor::create($data);
            return true;
        } catch (Exception $e) {
            Log::error("Error at Store Mentor " . $e->getMessage());
            return false;
        }
    }
}
