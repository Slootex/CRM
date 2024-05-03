<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class component_name extends Model
{
    use HasFactory;

    protected $table = 'component_names';

    public function deviceOrders()
    {
        return $this->belongsTo(device_orders::class);
    }
}
