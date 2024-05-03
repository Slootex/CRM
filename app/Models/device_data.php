<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device_data extends Model
{
    use HasFactory;

    public function deviceOrders() {
        return $this->belongsTo(device_orders::class, "component_number", "component_number");
    }

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
