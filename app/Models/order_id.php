<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_id extends Model
{
    use HasFactory;

    protected $primaryKey = 'process_id';

    public function new_orders_person_declaration()
    {
        return $this->hasOne(new_orders_person_declaration::class);
    }

    public function new_orders_car_declatation()
    {
        return $this->hasOne(new_orders_car_declatation::class);
    }

    public function new_leads_car_data()
    {
        return $this->hasOne(new_leads_car_data::class);
    }

    public function newLeadsPersonData()
    {
        return $this->hasOne(new_leads_person_data::class, 'process_id');
    }

    public function activeOrdersPersonData()
    {
        return $this->hasOne(active_orders_person_data::class, 'process_id');
    }

    public function new_order_accepten()
    {
        return $this->hasOne(new_order_accepten::class);
    }

    public function statuse()
    {
        return $this->hasOne(statuse::class, 'id', 'current_status');
    }

    public function statuseHistory()
    {
        return $this->hasOne(status_histori::class, 'process_id');
    }
}
