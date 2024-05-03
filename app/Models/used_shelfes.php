<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class used_shelfes extends Model
{
    use HasFactory;

    protected $table = 'used_shelfes';


    public function warenausgang()
    {
        return $this->belongsTo(warenausgang::class, 'component_number', 'component_number');
    }

    public function deviceOrders() 
    {
        return $this->belongsTo(device_orders::class, 'component_number', 'component_number');
    }

    public function wareneingang() 
    {
        return $this->belongsTo(wareneingang::class, 'component_number', 'component_number');
    }

    public function warenausganghistory() 
    {
        return $this->belongsTo(warenausgang_history::class, 'component_number', 'component_number');
    }
    public function entsorgung() 
    {
        return $this->hasOne(entsorgung_extendtime::class, 'component_number', 'component_number');
    }
}
