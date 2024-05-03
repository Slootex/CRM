<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class new_orders_person_declaration extends Model
{
    use HasFactory;

    public function new_order_image()
    {
        return $this->hasMany(new_order_image::class);
    }
}
