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
            $data = $request->getData();

            Event::create($data);

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
            $data = $request->detData();

            $oldData = Event::find($id);

            $this->deleteFile(
                $oldData->thumbnail
            );

            $oldData->update($data);

            Log::info('Event Updated');
            return true;

        } catch (Exception $e) {
            Log::error("Error at Update Event: {$e->getMessage()}");
            return false;

        }
    }

    public function destroy($id): bool
    {
        try {
            $event = Event::findorfail($id);

            $this->deleteFile(
                $event->thumbnail
            );

            $event->delete();

            Log::info('Event Deleted');
            return true;
        } catch (Exception $e) {
            Log::error("Error at Delete Event: {$e->getMessage()}");
            return false;
        }
    }



}

