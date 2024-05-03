<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class versand_statuscode extends Model
{
    use HasFactory;

    public function carrier() {
       return $this->belongsTo(carrier::class, "carrier", "carrier");
    }

    public function tracking() {
        return $this->belongsTo(tracking::class, "status", "status");
    }

    public function bezeichnungCustom() {
        return $this->hasOne(statuscodes_select::class, "bezeichnung", "bezeichnung");
    }
}
