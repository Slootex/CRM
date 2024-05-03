<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_tracking extends Model
{
    use HasFactory;

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
    public function newLeadsPersonData() {
        return $this->belongsTo(new_leads_person_data::class, "process_id", "process_id");
    }

    public function trackings() {
        return $this->hasMany(tracking::class, "trackingnumber", "trackingnumber");
    }
}
