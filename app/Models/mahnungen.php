<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahnungen extends Model
{
    use HasFactory;
    protected $table = "mahnungen";

    public function rechnunge() {
        $this->belongsTo(rechnungen::class, "rechnungsnummer", "rechnungsnummer");
    }
}
