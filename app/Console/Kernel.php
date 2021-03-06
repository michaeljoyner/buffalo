<?php

namespace App\Console;

use App\Console\Commands\FindMissingConversions;
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
        Commands\MakeProductDescriptionsUnique::class,
        Commands\CreateDefaultProductDescriptions::class,
        Commands\CreateDefaultCategoryDescriptions::class,
        Commands\ConvertExistingProductImages::class,
        Commands\ShiftGardenToolProducts::class,
        Commands\ShiftAutomotiveProducts::class,
        Commands\ShiftHandToolProducts::class,
        Commands\ShiftElectricalTools::class,
        Commands\GenerateSitemap::class,
        FindMissingConversions::class
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
        $schedule->command('sitemap:generate')->daily()->at('03:00');
    }
}
