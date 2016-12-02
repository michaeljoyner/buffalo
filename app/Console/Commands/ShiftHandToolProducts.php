<?php

namespace App\Console\Commands;

use App\ProductShifts\CuttingToolsShift;
use App\ProductShifts\PlumbingToolsShift;
use App\ProductShifts\ScrewdriverBitsShift;
use App\ProductShifts\SocketAndRatchetShift;
use App\ProductShifts\ToolCabinetsSetsAndLEDShift;
use Illuminate\Console\Command;

class ShiftHandToolProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:handtools';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the Hand Tool Shift jobs';

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
        $job1 = new ToolCabinetsSetsAndLEDShift();
        $job2 = new PlumbingToolsShift();
        $job3 = new CuttingToolsShift();
        $job4 = new ScrewdriverBitsShift();
        $job5 = new SocketAndRatchetShift();

        $job1->execute();
        $this->info('Tool cabinets, Tools sets and LED tools are now in place.');

        $job2->execute();
        $this->info('Plumbing tools have been shifted');

        $job3->execute();
        $this->info('Cutting tools are now organised');

        $job4->execute();
        $this->info('Screwdrivers and Bit sets have been shuffled into the right place');

        $job5->execute();
        $this->info('Sockets and ratchets have been shifted');

        $this->info('All done. Good job people, take five.');
    }
}
