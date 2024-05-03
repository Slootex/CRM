<?php

namespace App\Http\Livewire;

use App\Models\employee;
use App\Models\order_id;
use App\Models\status_histori;
use App\Models\statuse;
use Livewire\Component;

class Statuslead extends Component
{
    public $process_id;

    public $status_id;

    public $lead_person;

    public $lead_history;

    public $status_historys;

    public $lead_car;

    public $employee_created_lead;

    public $employee_last_changed;

    public $statuses;

    public $dir_files;

    public $employees;

    public $device_orders;

    public $order_id;

    public $new_status_date;

    public $new_status;

    public $new_employee;

    public $email_template;

    public $message;

    public $read;

    public function __construct($process_id)
    {
        $this->process_id = $process_id;

        $this->status_historys = status_histori::where('process_id', $this->process_id)->
                                            latest('updated_at')->get();

        $this->statuses = statuse::all();

        $this->order_id = order_id::where('process_id', $this->process_id)->first();

        $this->employees = employee::all();
    }

    public function mount($process_id)
    {
        $this->process_id = $process_id;

        $this->status_historys = status_histori::where('process_id', $this->process_id)->
                                            latest('updated_at')->get();

        $this->statuses = statuse::all();

        $this->order_id = order_id::where('process_id', $this->process_id)->first();
    }

    protected $rules = [
        'process_id' => 'required',
        'status_historys' => 'required',
        'statuses' => 'required',
        'employees' => 'required',
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updateStatus()
    {
        $order_id = order_id::where('process_id', $this->process_id)->first();
        $new_status_history = new status_histori();
        $new_status_history->process_id = $order_id->process_id;

        if ($order_id->current_status == null) {
            $new_status_history->last_status = $this->status_id;
        } else {
            $new_status_history->last_status = $order_id->current_status;
        }
        $new_status_history->changed_employee = 'LucasTest';
        $new_status_history->save();

        $order_id->current_status = $this->status_id;
        $order_id->save();

        foreach ($this->statuses as $status) {
            if ($status->id == $this->status_id) {
                $this->new_status = $status->name;
            }
        }

        $this->status_historys = status_histori::where('process_id', $this->process_id)->
                                                 latest('updated_at')->get();

        $this->statuses = statuse::all();

        $this->order_id = order_id::where('process_id', $this->process_id)->first();

        $this->employees = employee::all();
    }

    public function hydrate()
    {
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function render()
    {
        $this->status_historys = status_histori::where('process_id', $this->process_id)->
        latest('updated_at')->get();

        $this->statuses = statuse::all();

        $this->order_id = order_id::where('process_id', $this->process_id)->first();

        $this->employees = employee::all();

        $this->new_status = $this->new_status;

        return view('livewire.statuslead');
    }
}
