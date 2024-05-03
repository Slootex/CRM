<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archive_orders_car extends Model
{
    use HasFactory;

    protected $table = 'archive_orders_car';

    protected $primaryKey = 'process_id';

    public function archiveOrdersPerson()
    {
        $this->belongsTo(archive_orders_person::class);
    }
}
