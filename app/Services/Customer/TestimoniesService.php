<?php

namespace App\Services\Customer;

use App\Models\Testimonies;
use App\Services\Abstracts\CrudAbstract;
use Exception;
use Illuminate\Support\Facades\Log;

class TestimoniesService extends CrudAbstract
{
    public function store($request): bool
    {
        try {
            Testimonies::create($request->getData());

            Log::info("success store testimonies");
            return true;
        } catch (Exception $e) {
            Log::error("error store testimonies: " . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            Testimonies::findOrFail($id)->update($request->getData());

            Log::info("success update testimonies");
            return true;
        } catch (Exception $e) {
            Log::error("error update testimonies: " . $e->getMessage());
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            Testimonies::findOrFail($id)->delete();

            Log::info("success delete testimonies");
            return true;
        } catch (Exception $e) {
            Log::error("error delete testimonies: " . $e->getMessage());
            return false;
        }
    }
}
