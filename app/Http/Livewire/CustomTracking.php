<?php

namespace App\Http\Livewire;

use App\Models\tracking;
use App\Models\User;
use App\Models\user_tracking;
use App\Models\versand_statuscode;
use Livewire\Component;

class CustomTracking extends Component
{
    public $trackingOrder;
    
    public $trackings;
    public $process_id;
    public $codes;
    public $trackingStatus;

    public function render()
    {
        $this->trackingOrder = $this->process_id;
        $this->trackings = user_tracking::where("process_id", $this->process_id)->get();

        $this->codes = versand_statuscode::all();
        foreach($this->trackings as $t) {

            $lastTracking = tracking::where("trackingnumber", $t->trackingnumber)->latest()->first();

            if($lastTracking != null) {
                $this->trackingStatus[$t->trackingnumber] =  $lastTracking->status;
            }


            if($lastTracking != null) {
                $t->lastUpdate = $lastTracking->created_at->format("d.m.Y (H:i)");
            } else {
                $t->lastUpdate = "";
            }
        }
        return view('livewire.custom-tracking');
    }


   


}
