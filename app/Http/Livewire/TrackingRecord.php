<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TrackingRecord extends Component
{

    public $tracking;
    public function render()
    {
        return view('livewire.tracking-record');
    }
}
