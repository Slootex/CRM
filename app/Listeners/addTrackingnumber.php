<?php

namespace App\Listeners;

use App\Events\addTrackingNumber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class addTrackingnumber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\addTrackingNumber  $event
     * @return void
     */
    public function handle(addTrackingNumber $event)
    {
        //
    }
}
