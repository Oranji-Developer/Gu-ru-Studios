<?php

namespace App\Services\Admin;

use App\Models\Event;
use App\Services\Abstracts\CrudAbstract;
use Illuminate\Support\Facades\Log;
use App\Trait\FileHandleTrait;
use Exception;


class EventService extends CrudAbstract
{
    use FileHandleTrait;

    public function store($request): bool
    {
        try {
            Event::create($request->getData());

            log::info('Event Created');
            return true;
        } catch (Exception $e) {
            Log::error("Error at Store Event: {$e->getMessage()}");
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            Event::findOrFail($id)->update($request->getData());

            Log::info('Event Updated');
            return true;

        } catch (Exception $e) {
            Log::error("Error at Update Event: {$e->getMessage()}");
            return false;

        }
    }
}

