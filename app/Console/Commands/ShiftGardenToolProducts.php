<?php

namespace App\Console\Commands;

use App\ProductShifts\GardenHandToolsShift;
use App\ProductShifts\GardenPrunerShift;
use App\ProductShifts\PotsPlantersAndContainerAccessoriesShift;
use Illuminate\Console\Command;

class ShiftGardenToolProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:garden';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the Garden Tool Shift jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $job1 = new GardenHandToolsShift();
        $job2 = new PotsPlantersAndContainerAccessoriesShift();
        $job3 = new GardenPrunerShift();

        $job1->execute();
        $this->info('Garden hand tools shift done');

        $job2->execute();
        $this->info('Pots, Planters and Container Accessories shifted');

        $job3->execute();
        $this->info('Pruners have been reorganised');

        $this->info('All done');
    }
}
