<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intern extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public function shelfe()
    {
        return $this->hasOne(shelfe::class, 'component_number', 'component_number');
    }

    public function activeOrderPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
