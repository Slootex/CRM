<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zahlungen extends Model
{
    use HasFactory;

    protected $primaryKey   = "id";
    protected $table        = "zahlungen";

    public function rechnungen() {
        return $this->belongsTo(rechnungen::class, "rechnungsnummer", "rechnungsnummer");
    }

}
