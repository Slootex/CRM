<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class new_leads_person_data extends Model
{
    use HasFactory;


    public function orderId()
    {
        return $this->hasOne(order_id::class, 'process_id', 'process_id');
    }

    public function newLeadsCarData()
    {
        return $this->hasOne(new_leads_car_data::class, 'process_id', 'process_id');
    }

    public function userTracking()
    {
        return $this->hasMany(user_tracking::class, 'process_id', "process_id");
    }

    public function employee()
    {
        return $this->hasOne(employee::class, 'id', 'employee');
    }

    public function statuse() {
        return $this->hasMany(status_histori::class, "process_id", "process_id");
    }

    public function files() {
        return $this->hasMany(file::class, "process_id", "process_id");
    }

    public function callbacks() {
        return $this->hasMany(phone_history::class, "process_id", "process_id");
    }

    public function zuweisung() {
        return $this->hasMany(zuweisung::class, "process_id", "process_id");
    }

    public function kundenkonto() {
        return $this->hasOne(kundenkonto::class, "process_id", "process_id");
    }

}
