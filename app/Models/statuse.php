<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statuse extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public function statusHistori() {
        return $this->belongsTo(status_histori::class, "last_status", "id");
    }

    public function orderId()
    {
        return $this->belongsTo(order_id::class);
    }
}
