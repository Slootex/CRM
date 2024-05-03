<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statuscodes_select extends Model
{
    use HasFactory;

    protected $table = "statuscodes_select";

    public function versandStatuscodes() {
        return $this->belongsTo(versand_statuscode::class, "bezeichnung", "bezeichnung");
    }
}
