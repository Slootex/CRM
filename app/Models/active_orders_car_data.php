<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class active_orders_car_data extends Model
{
    use HasFactory;

    public function activeOrdersPersonData()
    {
        $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
