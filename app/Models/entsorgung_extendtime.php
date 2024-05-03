<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entsorgung_extendtime extends Model
{
    use HasFactory;

    protected $table = 'entsorgung_extendtime';

    public function usedShelfes() {
        return $this->belongsTo(used_shelfes::class, 'component_number', 'component_number');
    }

  
}
