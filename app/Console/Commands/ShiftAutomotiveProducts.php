<?php

namespace App\Console\Commands;

use App\ProductShifts\AutomotiveShift;
use Illuminate\Console\Command;

class ShiftAutomotiveProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shifts:automotive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the Automotive Tools Shift jobs';

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
        $job1 = new AutomotiveShift();

        $job1->execute();
        $this->info('Automotive tools shifted');

        $this->info('All done here. Move on.');
    }
}
