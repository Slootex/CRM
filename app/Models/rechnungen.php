<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rechnungen extends Model
{
    use HasFactory;

    protected $primaryKey   = "id";
    protected $table        = "rechnungen";

    public function zahlungen() {
        return $this->hasMany(zahlungen::class, "rechnungsnummer", "rechnungsnummer");
    }

    public function kundenkonto() {
        return $this->belongsTo(kundenkonto::class, "id", "kundenkonto");
    }

    public function mahnungen() {
        return $this->hasMany(mahnungen::class, "rechnungsnummer", "rechnungsnummer");
    }

    public function audiofiles() {
        return $this->hasOne(audiofiles::class, "rechnungsnummer", "rechnungsnummer");
    }


}
