<?php

namespace App\Console\Commands;

use App\Enum\Courses\StatusEnum;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateExpiredEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update expired events to inactive status daily at midnight';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('Starting update expired events task');

        $updatedCount = Event::query()
            ->whereRaw('end_date < CURRENT_DATE')
            ->where('status', '!=', StatusEnum::INACTIVE->value)
            ->update(['status' => StatusEnum::INACTIVE->value]);

        Log::info('Completed updating expired events', [
            'updated_count' => $updatedCount
        ]);

        $this->info("Successfully updated {$updatedCount} expired events");
    }
}
