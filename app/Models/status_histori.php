<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_histori extends Model
{
    use HasFactory;


    public function statuseMain() {
        return $this->hasOne(statuse::class, "id", "last_status");
    }

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }

    public function newLeadsPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
