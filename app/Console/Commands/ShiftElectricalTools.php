<?php

namespace App\Console\Commands;

use App\ProductShifts\ElectricalToolsShift;
use Illuminate\Console\Command;

class ShiftElectricalTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:electric';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the Electrical Tools Shift jobs';

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
        $job1 = new ElectricalToolsShift();

        $job1->execute();
        $this->info('Electrical things have happened');

        $this->info('All good. Thats a wrap.');
    }
}
