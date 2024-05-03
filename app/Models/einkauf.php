<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class einkauf extends Model
{
    use HasFactory;

    protected $table = "einkauf";

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
