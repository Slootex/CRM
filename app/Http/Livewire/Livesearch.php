<?php

namespace App\Http\Livewire;

use App\Models\active_orders_person_data;
use App\Models\employee;
use App\Models\order_id;
use App\Models\statuse;
use Livewire\Component;

class Livesearch extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        $statuses = statuse::all();
        $active_orders = active_orders_person_data::latest()->get();
        $order_ids = order_id::latest()->get();
        $employee = employee::all();

        return view('livewire.livesearch', [
            'statuses' => $statuses,
            'active_orders' => $active_orders,
            'order_ids' => $order_ids,
            'employees' => $employee,
        ]);
    }
}
