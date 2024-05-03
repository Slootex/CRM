<?php

namespace App\Console\Commands;

use App\Http\Controllers\tracking_CONTROLLER;
use Illuminate\Console\Command;

class saveNewTrackingId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle($id)
    {
        $tracking = new tracking_CONTROLLER();
        $tracking->updateTrackings($id);
        
        return Command::SUCCESS;
    }
}
