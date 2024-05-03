<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tracking extends Model
{
    use HasFactory;

    public function userTracking() {
        return $this->belongsTo(user_tracking::class, "trackingnumber", "trackingnumber");
    }

    public function code() {
        return $this->hasOne(versand_statuscode::class, "status", "status");
    }
}
