<?php

namespace App\Services\Customer;

use App\Models\Children;
use App\Services\Abstracts\CrudAbstract;
use Illuminate\Support\Facades\Log;

class ChildrenService extends CrudAbstract
{
    public function store($request): bool
    {
        try {
            Children::create($request->getData());

            Log::info("Store children data Success");
            return true;
        } catch (\Exception $e) {
            Log::error("Error when store children data " . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            Children::findOrFail($id)->update($request->getData());

            Log::info("Update children data Success");
            return true;
        } catch (\Exception $e) {
            Log::error("Error when update children data " . $e->getMessage());
            return false;
        }
    }
}
