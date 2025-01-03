<?php

namespace App\Services\Customer;

use App\Services\Abstracts\CrudAbstract;
use Illuminate\Support\Facades\Log;

class ProfileService extends CrudAbstract
{
    public function update($request, ?int $id = null): bool
    {
        try {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            Log::info("profile updated: {$request->user()->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("error when updating profile: {$e->getMessage()}");
            return false;
        }
    }
}
