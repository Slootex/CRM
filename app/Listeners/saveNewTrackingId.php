<?php

namespace App\Listeners;

use App\Http\Controllers\tracking_CONTROLLER;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class saveNewTrackingId implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    use InteractsWithQueue;


    public $id;

    public function __construct($id)
    {
        $tracking = new tracking_CONTROLLER();
        $tracking->updateTrackings($id);
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

    }
}
