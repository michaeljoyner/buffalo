<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateDefaultProductDescriptions::class,
        Commands\CreateDefaultCategoryDescriptions::class,
        Commands\ConvertExistingProductImages::class,
        Commands\ShiftGardenToolProducts::class,
        Commands\ShiftAutomotiveProducts::class,
        Commands\ShiftHandToolProducts::class,
        Commands\ShiftElectricalTools::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        $schedule->call(function() {
            Log::info('Mooz made a sentence');
        })->everyMinute();
    }
}
