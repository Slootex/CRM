<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carrier extends Model
{
    use HasFactory;
    
    protected $table = "carrier";

    public function versandStatuscode() {
        return $this->hasMany(versand_statuscode::class, "carrier", "carrier");
    }
}
