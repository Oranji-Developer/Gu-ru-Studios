<?php

namespace App\Console\Commands;

use App\Enum\Users\StatusEnum;
use App\Models\UserCourse;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateExpiredUserCourse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update expired user courses to completed status';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('Starting update expired user courses task');

        $updatedCount = UserCourse::query()
            ->whereRaw('end_date < CURRENT_DATE')
            ->where('status', '!=', StatusEnum::COMPLETED->value)
            ->update(['status' => StatusEnum::COMPLETED->value]);

        Log::info('Completed updating expired user courses', [
            'updated_count' => $updatedCount
        ]);

        $this->info("Successfully updated {$updatedCount} expired courses");
    }
}
