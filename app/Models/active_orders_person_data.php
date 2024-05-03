<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class active_orders_person_data extends Model
{
    use HasFactory;


    public function processId()
    {
        return $this->belongsTo(process_id::class);
    }
    

    public function orderId()
    {
        return $this->hasOne(order_id::class, 'process_id');
    }

    public function user()
    {
        return $this->hasOne(user::class, 'id', 'employee');
    }

    public function activeOrdersCarData()
    {
        return $this->hasOne(active_orders_car_data::class, 'process_id', "process_id");
    }

    public function userTracking()
    {
        return $this->hasMany(user_tracking::class, 'process_id', "process_id");
    }

    public function devices()
    {
        return $this->hasMany(device_orders::class, 'process_id', 'process_id');
    }

    public function statuse() {
        return $this->hasMany(status_histori::class, "process_id", "process_id");
    }

    public function files() {
        return $this->hasMany(file::class, "process_id", "process_id");
    }

    public function rechnungen() {
        return $this->hasMany(rechnungen::class, "process_id", "process_id");
    }

    public function warenausgang() {
        return $this->hasMany(warenausgang::class, "process_id", "process_id");
    }
    public function intern() {
        return $this->hasMany(intern::class, "process_id", "process_id");
    }

    public function workflow() {
        return $this->hasMany(user_workflow::class, "process_id", "process_id");
    }

    public function einkäufe() {
        return $this->hasMany(einkauf::class, "process_id", "process_id");
    }

    public function deviceData() {
        return $this->hasMany(device_data::class, "process_id", "process_id");
    }

    public function zuweisung() {
        return $this->hasMany(zuweisung::class, "process_id", "process_id");
    }

    public function kundenkonto() {
        return $this->hasOne(kundenkonto::class, "process_id", "process_id");
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
