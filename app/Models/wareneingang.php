<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wareneingang extends Model
{
    use HasFactory;

    protected $table = 'wareneingang';

    public function shelfe() {
        return $this->hasOne(used_shelfes::class, "component_number", "component_number");
    }
}
