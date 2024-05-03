<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class audiofiles extends Model
{
    use HasFactory;
    protected $table = "audiofiles";
    
    public function rechnungen() {
        return $this->belongsTo(rechnungen::class, "rechnungsnummer", "rechnungsnummer");
    }

}
