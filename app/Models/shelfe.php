<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shelfe extends Model
{
    use HasFactory;

    protected $table = 'shelfes';

    protected $primaryKey = 'id';

    public function deviceOrders()
    {
        return $this->hasOne(device_orders::class, 'component_number');
    }

    public function intern()
    {
        return $this->belongsTo(intern::class, 'component_number', 'component_number');
    }

    public function warenausgang()
    {
        return $this->belongsTo(warenausgang::class, 'component_number', 'component_number');
    }
}
