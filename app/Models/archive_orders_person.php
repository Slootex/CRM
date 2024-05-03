<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archive_orders_person extends Model
{
    use HasFactory;

    protected $table = 'archive_orders_person';

    protected $primaryKey = 'process_id';

    public function processId()
    {
        return $this->belongsTo(process_id::class);
    }

    public function orderId()
    {
        return $this->hasOne(order_id::class, 'process_id');
    }

    public function employee()
    {
        return $this->hasOne(employee::class, 'id', 'employee');
    }

    public function activeOrdersCarData()
    {
        return $this->hasOne(archive_orders_car::class, 'process_id');
    }
}
