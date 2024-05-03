<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device_orders extends Model
{
    use HasFactory;

    protected $table = 'device_orders';
    
    public function shelfe()
    {
        return $this->belongsTo(shelfe::class);
    }

    public function newLeadsPersonData()
    {
        return $this->hasOne(new_leads_person_data::class, 'process_id', 'process_id');
    }

    public function componentName()
    {
        return $this->hasOne(component_name::class, 'id', 'component');
    }

    public function usedShelfes()
    {
        return $this->hasOne(used_shelfes::class, 'component_number', 'component_number');
    }

    public function activeOrders()
    {
        return $this->belongsTo(active_orders_person_data::class, 'process_id', 'process_id');
    }

    public function deviceData() {
        return $this->hasOne(device_data::class, "component_number", "component_number");
    }

}
